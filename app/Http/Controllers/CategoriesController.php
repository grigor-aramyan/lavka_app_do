<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class CategoriesController extends Controller
{
    private $products_paginate = 20;

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
    public function index()
    {
        $categories = Category::all();

        $products = Product::inRandomOrder()->limit(20)->get();

        return view('categories', [
            'categories' => $categories,
            'current_cat' => [ 'name' => 'Random', 'id' => 0 ],
            'products' => $products,
            'pages_count' => 1
        ]);
    }

    public function category_products_paged(Request $request, $cat_id, $page = 1)
    {
        $categories = Category::all();

        $current_category = Category::find($cat_id);
        if (!$current_category)
        {
            $cat_id = null;
        }

        $products = Product::where('category_id', $cat_id)->where('count', '>', 0)
            ->offset(($page - 1) * $this->products_paginate)
            ->limit($this->products_paginate)
            ->get();

        $products_count = Product::where('category_id', $cat_id)->where('count', '>', 0)
            ->get()->count();
        $pages_count = intval(ceil($products_count / $this->products_paginate));

        return view('categories', [
            'categories' => $categories,
            'current_cat' => $current_category ? $current_category : [ 'name' => 'Random', 'id' => 0 ],
            'products' => $products,
            'pages_count' => $pages_count
        ]);
    }
}
