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
                'password'          => Hash::make('hogehoge'),
                'password_plane'    => 'hogehoge',
                'customer_id'    => 0,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        User::insert($data);
    }
}
