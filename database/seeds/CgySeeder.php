<?php

use Illuminate\Database\Seeder;
use App\Cgy;

class CgySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cgy::truncate();
        factory(Cgy::class,10)->create();
    }
}
