<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;

class NotificationService
{
    public function sendNotification(User $user): mixed {
        $client = new Client();

        $notificationResponse = $client->post(env('NOTIFICATION_URL'), [
            'json' => [
                'data' => [
                    'email' => $user->email,
                    'message' => "Successfully created a transaction"
                ]
            ]
        ]);

        return json_decode($notificationResponse->getBody()->getContents(), true);
    }
}
