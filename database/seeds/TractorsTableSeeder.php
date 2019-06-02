<?php

use App\Tractors;
use Illuminate\Database\Seeder;

class TractorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Tractors::class, 2)->create();
    }	
}
