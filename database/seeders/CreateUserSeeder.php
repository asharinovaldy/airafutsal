<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make dummy data for user
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@aira.com',
                'is_admin' => '1',
                'password' => bcrypt('admin'),
            ],
            [
                'name' => 'User',
                'email' => 'user@aira.com',
                'is_admin' => '0',
                'password' => bcrypt('user'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
