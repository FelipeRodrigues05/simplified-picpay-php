<?php

namespace App\Services;

use App\Exceptions\CustomUnauthorizedException;
use App\Models\{Transaction, User};
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TransactionService
{
    public UserService $userService;
    public NotificationService $notificationService;
    private string $authorizationURL;

    /**
     * @param UserService           $userService
     * @param NotificationService   $notificationService
     */
    public function __construct(UserService $userService, NotificationService $notificationService)
    {
        $this->userService      = $userService;
        $this->notificationService = $notificationService;
        $this->authorizationURL = env('AUTHORIZATION_URL');
    }

    /**
     * @param array $data
     * @return Transaction
     * @throws CustomUnauthorizedException
     * @throws GuzzleException
     */
    public function createTransaction(array $data): Transaction
    {
        $sender     = $this->userService->findUserByID($data['sender_id']);
        $receiver   = $this->userService->findUserByID($data['receiver_id']);

        $this->userService->validateTransaction($sender, $data['amount']);

        $isAuthorized = $this->authorizeTransaction();

        if(!$isAuthorized) {
            throw new CustomUnauthorizedException("Unauthorized transaction");
        }

        $this->saveUserBalance($sender, $receiver, $data['amount']);

        $this->notificationService->sendNotification($sender);
        $this->notificationService->sendNotification($receiver);

        return $this->saveTransaction($sender, $receiver, $data['amount']);
    }

    /**
     * @throws GuzzleException
     */
    private function authorizeTransaction(): mixed
    {
        try {
            $client = new Client();
            $response = $client->get($this->authorizationURL);

            $responseContent = json_decode($response->getBody()->getContents(), true)['data'];

            return $responseContent['authorization'];
        } catch(\Exception $e) {
            return response(['success' => false, 'message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param User $sender
     * @param User $receiver
     * @param float $amount
     * @return Transaction
     */
    private function saveTransaction(User $sender, User $receiver, float $amount): Transaction
    {
        return Transaction::create([
            'sender_id'     => $sender->id,
            'receiver_id'   => $receiver->id,
            'amount'        => $amount
        ]);
    }

    /**
     * @param User $sender
     * @param User $receiver
     * @param float $amount
     * @return void
     */
    private function saveUserBalance(User $sender, User $receiver, float $amount): void
    {
        $sender->balance -= $amount;
        $receiver->balance += $amount;

        $sender->save();
        $receiver->save();
    }
}
