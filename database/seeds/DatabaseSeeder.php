<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UserSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        $this->call(CgySeeder::class);
        $this->call(SongsTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(CgyTagSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');


    }
}
