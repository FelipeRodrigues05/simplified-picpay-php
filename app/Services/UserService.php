<?php

namespace App\Services;

use App\Enum\UserType;
use App\Exceptions\CustomException;
use App\Models\User;

class UserService
{
    /**
     * @param User $user
     * @param float $amount
     * @return void
     * @throws CustomException
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

    /**
     * @param int $id
     * @return User
     */
    public function findUserByID(int $id): User
    {
        return User::find($id);
    }
}
