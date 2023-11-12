<?php

namespace Database\Seeders;

use App\Models\MStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MStatus::truncate();

        $data = [
            ['name' => '新規', 'color' => '#448AFF', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '衣装選択中', 'color' => '#FBC02D', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '注文済み', 'color' => '#2E7D32', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '終了', 'color' => '#546E7A', 'created_at' => now(), 'updated_at' => now()],
        ];

        MStatus::insert($data);
    }
}
