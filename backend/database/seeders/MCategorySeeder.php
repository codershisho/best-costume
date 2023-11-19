<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MCategory;

class MCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MCategory::truncate();

        // サンプルデータを作成
        MCategory::create([
            'name' => 'ALL',
            'color' => '#448AFF',
        ]);

        MCategory::create([
            'name' => 'Mens',
            'color' => '#448AFF',
        ]);

        MCategory::create([
            'name' => 'Womens',
            'color' => '#448AFF',
        ]);

        MCategory::create([
            'name' => 'Kids',
            'color' => '#448AFF',
        ]);

        MCategory::create([
            'name' => 'Others',
            'color' => '#448AFF',
        ]);
    }
}
