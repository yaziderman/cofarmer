<?php
use App\Tractors;
use App\User;
use App\Fields;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
            Model::unguard();
          
            $this->call(UserTableSeeder::class);

	//         User::reguard();
	// //       $this->call(FieldsTableSeeder::class);
	//        Tractors::unguard();
          
	       $this->call(TractorsTableSeeder::class);

		   Model::reguard();
    }
}
