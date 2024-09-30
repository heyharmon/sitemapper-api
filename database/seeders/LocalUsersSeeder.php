<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DDD\Domain\Base\Users\User;

class LocalUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Jane Doe',
                'email' => 'jane@doe.com',
                'role' => 'editor',
                'organization_id' => 1,
                'password' => bcrypt(config('seeding.user_password')),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
