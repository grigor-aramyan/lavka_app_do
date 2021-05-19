<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();

        $new_products = Product::where('id', '>', '0')->orderBy('id', 'DESC')->limit(10)->get();
        $recommended_products = Product::inRandomOrder()->limit(10)->get();
        $top_products = Product::withCount('orders')->orderBy('orders_count', 'DESC')->limit(10)->get();

        return view('home', [
            'new_products' => $new_products,
            'recommended' => $recommended_products,
            'top_products' => $top_products,
            'categories' => $categories,
        ]);
    }
}
