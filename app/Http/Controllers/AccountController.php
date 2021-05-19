<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class AccountController extends Controller
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

    public function update(Request $request)
    {
        $current_user = auth()->user();

        $current_user->name = $request->fullname;
        $current_user->phone = $request->editedAccountPhone;

        $saved = $current_user->save();

        if (!$saved)
        {
            return response()->json([
                'status' => 400,
                'msg' => 'Couldn\'t update account data'
            ]);
        }

        return response()->json([
            'status' => 200,
            'msg' => 'ok'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $current_user = auth()->user();

        $delivery_address = null;
        $orders = null;
        if ($request->query('status') != null)
        {
            if ($request->query('address') != null && $request->query('orderId') != 'null')
            {
                $delivery_address = $request->query('address');

                if ($request->query('status') == 'All')
                {
                    $orders = Order::where('delivery_address', $delivery_address)
                        ->where('id', $request->query('orderId'))
                        ->orderBy('id', 'DESC')->get();
                } else {
                    $orders = Order::where('delivery_address', $delivery_address)
                        ->where('id', $request->query('orderId'))
                        ->where('status', strtolower($request->query('status')))
                        ->orderBy('id', 'DESC')->get();
                }

            } else if (($request->query('orderId') != null) && ($request->query('orderId') != 'null')) {
                if ($request->query('status') == 'All')
                {
                    $orders = Order::where('id', $request->query('orderId'))
                        ->where('user_id', $current_user->id)
                        ->orderBy('id', 'DESC')->get();
                } else {
                    $orders = Order::where('id', $request->query('orderId'))
                        ->where('status', strtolower($request->query('status')))
                        ->where('user_id', $current_user->id)
                        ->orderBy('id', 'DESC')->get();
                }
            } else {
                // only status field present
                if ($request->query('status') == 'All')
                {
                    $orders = Order::where('user_id', $current_user->id)
                        ->orderBy('id', 'DESC')->get();
                } else {
                    $orders = Order::where('user_id', $current_user->id)
                        ->where('status', strtolower($request->query('status')))
                        ->orderBy('id', 'DESC')->get();
                }
            }
        } else if ($request->query('address') != null)
        {
            $delivery_address = $request->query('address');

            $orders = Order::where('delivery_address', $delivery_address)->orderBy('id', 'DESC')->get();
        } else {
            $orders = Order::where('user_id', $current_user->id)->orderBy('id', 'DESC')->get();
        }

        return view('account', [
            'orders' => $orders
        ]);
    }
}
