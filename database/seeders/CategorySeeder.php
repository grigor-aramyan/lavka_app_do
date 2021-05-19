<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'Fruits', 'image_uri' => '/images/icons/banana_ic.png' ],
            [ 'name' => 'Meat', 'image_uri' => '/images/icons/meet_ic.png' ],
            [ 'name' => 'Seafood', 'image_uri' => '/images/icons/seafood_ic.png' ],
            [ 'name' => 'Drink', 'image_uri' => '/images/icons/drink_ic.png' ]
        ];
        Category::insert($data);
        
    }
}
