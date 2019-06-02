<?php

use Illuminate\Database\Seeder;
use App\Fields;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


	  factory(User::class, 2)->create()->each(function($u) {
	    $u->fields()->save(factory(Fields::class)->make());
	  });

    }
}
