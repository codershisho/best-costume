<?php

namespace Database\Seeders;

use App\Models\MScrapeSite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MScrapeSitesTableSeeder extends Seeder
{
    public function run()
    {
        MScrapeSite::truncate();

        $data = [
            ['name' => 'RENCA', 'url' => 'https://renca.jp/', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '京都かしいしょう', 'url' => 'https://kyoto-kashiisyo.jp/', 'created_at' => now(), 'updated_at' => now()],
        ];

        MScrapeSite::insert($data);
    }
}
