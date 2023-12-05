<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(MCategorySeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(MScrapeSitesTableSeeder::class);
    }
}
