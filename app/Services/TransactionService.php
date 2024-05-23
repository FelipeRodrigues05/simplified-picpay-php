<?php

namespace App\Services;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Decimal\Decimal;
use GuzzleHttp\Client;
use Illuminate\Validation\UnauthorizedException;

class TransactionService
{
    public UserService $userService;
    private string $authorizationURL;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
        $this->authorizationURL = "https://util.devi.tools/api/v2/authorize";
    }

    public function createTransaction(StoreTransactionRequest $request): Transaction {
        $sender = $this->userService->findUserByID($request->sender_id);
        $receiver = $this->userService->findUserByID($request->receiver_id);

        $this->userService->validateTransaction($sender, $request->amount);

        $isAuthorized = $this->authorizeTransaction();

        if(!$isAuthorized) {
            throw new UnauthorizedException("Unauthorized transaction");
        }

        $this->saveUserBalance($sender, $receiver, $request->amount);

        return $this->saveTransaction($sender, $receiver, $request->amount);
    }

    private function authorizeTransaction(): Transaction {
        $client = new Client();
        $response = $client->get($this->authorizationURL);

        $responseContent = json_decode($response->getBody()->getContents(), true);
        return $responseContent['data']['authorization'];
    }

    private function saveTransaction(User $sender, User $receiver, Decimal $amount): Transaction {
        return Transaction::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'amount' => $amount
        ]);
    }

    private function saveUserBalance(User $sender, User $receiver, Decimal $amount): void {
        $sender->balance = $sender->balance->subtract($amount);
        $receiver->balance = $receiver->balance->add($amount);

        $sender->save();
        $receiver->save();

        return;
    }
}
