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
            ['name' => 'Mens', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Womens', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Boys', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Girls', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ODDO. SELECT', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'きもの（アンサンブル）', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '男性袴', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'タキシード（ウェディング）', 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => '女性袴', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '振袖', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '訪問着', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '訪問着（夏用）', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '色留袖', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '黒留袖', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '白無垢', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '色打掛', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '黒引振袖', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '色引振袖', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ドレス（ウェディング）', 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['name' => '七五三（7歳）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '七五三（5歳）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '七五三（3歳）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'スーツ', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '男児用袴（ハーフ成人式）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'お宮参り（産着）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'お宮参り（産着／夏用）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baby（タキシード）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baby（着物）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baby（コスチューム）', 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['name' => '七五三（7歳）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '七五三（5歳）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '七五三（3歳）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ドレス', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '女児用袴（ハーフ成人式）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'お宮参り（産着）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'お宮参り（産着／夏用）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baby（ドレス）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baby（着物）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baby（コスチューム）', 'parent_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'アンティーク着物（7歳）', 'parent_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'アンティーク着物（5歳）', 'parent_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'アンティーク着物（3歳）', 'parent_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '帯レンタル', 'parent_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ];

        MMenu::insert($data);
    }
}
