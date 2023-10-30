<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        $data = [
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('hogehoge'),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name' => 'test',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('hogehoge'),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        User::insert($data);
    }
}
