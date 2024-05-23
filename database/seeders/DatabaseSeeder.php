<?php

namespace Database\Seeders;

use App\Enum\UserType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();

        User::factory(1)->create([
            'user_type' => UserType::SHOPKEEPER->value
        ]);
    }
}
