<?php

namespace App\Services;

use App\Enum\UserType;
use App\Exceptions\CustomException;
use App\Models\User;

class UserService
{
    /**
     * @throws \Exception
     */
    public function validateTransaction(User $user, float $amount): void
    {
        if ($user->user_type == UserType::SHOPKEEPER->value) {
            throw new CustomException('Shopkeepers cannot make transactions');
        }

        if (($user->balance < $amount) || $user->balance == 0) {
            throw new CustomException('Insufficient funds');
        }
    }

    public function findUserByID(int $id): User
    {
        return User::find($id);
    }
}
