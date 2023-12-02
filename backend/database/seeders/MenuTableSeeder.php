<?php

namespace Database\Seeders;

use App\Models\MMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MMenu::truncate();

        $data = [
            ['name' => 'MENS', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'WOMENS', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'KIDS', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ドレス', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'スーツ', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '七五三', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '振袖', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '着物', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'ドレス', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'スーツ', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '七五三', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '振袖', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '着物', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'ドレス', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'スーツ', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '七五三', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '振袖', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '着物', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ];

        MMenu::insert($data);
    }
}
