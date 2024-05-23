<?php

namespace App\Services;

use App\Enum\UserType;
use App\Models\User;
use Decimal\Decimal;

class UserService
{
    /**
     * @throws \Exception
     */
    public function validateTransaction(User $user, Decimal $amount)
    {
        if ($user->usertype == UserType::SHOPKEEPER) {
            throw new \Exception('Shopkeepers cannot make transactions');
        }

        if ($user->balance->compare($amount) < 0) {
            throw new \Exception('Insufficient funds');
        }
    }

    public function findUserByID(User $user): User
    {
        return $user;
    }

    public function findUserByEmail(User $user)
    {
        return User::where('email', $user->email);
    }

    public function saveUser(User $user)
    {
        return User::create($user);
    }
}
