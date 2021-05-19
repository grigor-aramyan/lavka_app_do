<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $current_user = auth()->user();
        if (!$current_user)
        {
            return response()->json([
                'msg' => 'unauthenticated',
                'status' => 401
            ]);
        }

        $shopping_date = null;
        if (isset($request->shopping_date) && !empty($request->shopping_date))
        {
            $shopping_date = $request->shopping_date;
        } else {
            $shopping_date = \Carbon\Carbon::now()->format('m-d-Y');
        }

        $products_encoded = $request->products;
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

        $new_order = new Order;
        $new_order->user_id = $current_user->id;
        $new_order->total_price = $total_cost;
        $new_order->counts_encoded = $products_encoded;
        $new_order->ordered_for_date = $shopping_date;
        if (isset($request->delivery_address))
        {
            $new_order->delivery_address = $request->delivery_address;
        }
        if (isset($request->delivery_phone))
        {
            $new_order->delivery_phone = $request->delivery_phone;
        }

        $saved = $new_order->save();
        if (!$saved)
        {
            return response()->json([
                'msg' => 'couldn\'t save the order',
                'status' => 400
            ]);
        }

        foreach ($carted_product_ids as $cpi)
        {
            $new_order->products()->attach($cpi);
        }

        return response()->json([
            'msg' => 'ok',
            'status' => 201
        ]);

    }
}
