<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Warehouse;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $w = Warehouse::where('id', '>', 0)->first();

        $data = [
            [ 'name' => 'test product', 'description' => 'test description', 'price' => '99', 'count' => 23, 'warehouse_id' => $w->id, 'image_uri' => 'https://worldofmeat.ru/wp-content/uploads/2019/12/rib_eye_small_1_1-1-scaled.jpg' ],
            [ 'name' => 'test product 2', 'description' => 'test description 2', 'price' => '990', 'count' => 24, 'warehouse_id' => $w->id, 'image_uri' => null ]
        ];
        Product::insert($data);
    }
}
