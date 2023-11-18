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
        ]);

        MCategory::create([
            'name' => 'Mens',
        ]);

        MCategory::create([
            'name' => 'Womens',
        ]);

        MCategory::create([
            'name' => 'Kids',
        ]);

        MCategory::create([
            'name' => 'Others',
        ]);
    }
}
