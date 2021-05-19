<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([ 'email' => 'guest443532@lavkaapp.com', 'password' => Hash::make('secret88D') ]);

        $this->call([
            CategorySeeder::class,
            WarehouseSeeder::class,
            ProductSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
