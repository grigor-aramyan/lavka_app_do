<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $products_encoded = $request->query('products');
        if (!$products_encoded)
        {
            return view('cart', [
                'products' => null,
                'total_cost' => 0
            ]);
        }

        $products_encoded_array = explode(':::', $products_encoded);

        $carted_product_ids = [];
        $carted_products_map = [];
        foreach ($products_encoded_array as $pe)
        {
            if (empty($pe))
            {
                break;
            }

            $exploded = explode('-', $pe);
            
            array_push($carted_product_ids, $exploded[0]);
            $carted_products_map += [
                $exploded[0] => $exploded[1]
            ];
        }

        $carted_products = Product::whereIn('id', $carted_product_ids)->get();

        $total_cost = 0;
        foreach ($carted_products as $cp)
        {
            $total_cost += ($cp->price * $carted_products_map[$cp->id]);
        }

        return view('cart', [
            'products' => $carted_products,
            'total_cost' => $total_cost
        ]);
    }
}
