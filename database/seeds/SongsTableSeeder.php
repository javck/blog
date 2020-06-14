<?php

use Illuminate\Database\Seeder;
use \App\Song;
use \Carbon\Carbon;
use \Faker\Factory;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空songs表格
        Song::truncate();
        //寫資料
        factory(Song::class,100)->create();
    }
}
