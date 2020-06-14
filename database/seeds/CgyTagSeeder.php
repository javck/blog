<?php

use Illuminate\Database\Seeder;

class CgyTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\CgyTag::truncate();
        factory(\App\CgyTag::class,50)->create();
    }
}
