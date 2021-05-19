<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Imports\ProductsImport;
use App\Models\Warehouse;
use App\Models\Category;

class AdminController extends Controller
{
    private $items_per_page = 20;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'login',
            'authenticate',
            'index',
            'orders_store',
            'users_store',
            'products_store',
            'products_import',
        ]);
    }

    public function products_import(Request $request)
    {
        $current_user = auth()->user();
        if (!$current_user || !$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $path = $request->csv_import->store('products_matrices', 'public');

        $warehouse_id = Warehouse::all()->first()->id;

        $import_file = 'storage/' . $path;
        Excel::import(new ProductsImport($warehouse_id), $import_file);

        return back();
    }

    public function products_image(Request $request)
    {
        $current_user = auth()->user();
        if (!$current_user || !$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        if (!isset($request->product_id))
        {
            return back();
        }

        $given_product = Product::find($request->product_id);
        if (!$given_product)
        {
            return back();
        }

        if (!isset($request->product_image))
        {
            return back();
        }

        $path = $request->product_image->store('products_images', 'public');
        $image_path = 'storage/' . $path;

        $given_product->image_uri = $image_path;
        $saved = $given_product->save();

        return back();

    }

    public function products_store(Request $request)
    {
        $current_user = auth()->user();
        if (!$current_user || !$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $given_product = Product::find($request->editedProductId);
        if (!$given_product)
        {
            return response()->json([
                'status' => 400,
                'msg' => 'Product not found'
            ]);
        }

        $given_product->name = $request->editedProductName;
        $given_product->price = $request->editedProductPrice;
        $given_product->count = $request->editedProductCount;

        if (isset($request->editedProductCategory))
        {
            $given_product->category_id = $request->editedProductCategory;
        } else {
            $given_product->category_id = null;
        }

        $saved = $given_product->save();

        if (!$saved)
        {
            return response()->json([
                'status' => 400,
                'msg' => 'Could not update order data'
            ]);
        }

        return response()->json([
            'status' => 200,
            'msg' => 'Ok'
        ]);
    }

    public function users_store(Request $request)
    {
        $current_user = auth()->user();
        if (!$current_user || !$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $given_user = User::where('id', $request->editedId)->where('email', '=', $request->editedEmail)->first();

        if (!$given_user)
        {
            return response()->json([
                'status' => 400,
                'msg' => 'User not found'
            ]);
        }

        $given_user->name = $request->editedName;
        $given_user->phone = $request->editedPhone;
        $given_user->role = $request->editedRole;

        $saved = $given_user->save();

        if (!$saved)
        {
            return response()->json([
                'status' => 400,
                'msg' => 'Could not update user data'
            ]);
        }

        return response()->json([
            'status' => 200,
            'msg' => 'Ok'
        ]);
    }

    public function orders_store(Request $request)
    {
        $current_user = auth()->user();
        if (!$current_user || !$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $given_order = Order::where('id', $request->editedOrderId)->first();
        if (!$given_order)
        {
            return response()->json([
                'status' => 400,
                'msg' => 'Order not found'
            ]);
        }

        $given_order->ordered_for_date = $request->editedOrderOrderedForDate;
        $given_order->total_price = $request->editedOrderPrice;
        $given_order->delivery_phone = $request->editedOrderPhone;
        $given_order->status = $request->editedOrderStatus;

        $saved = $given_order->save();

        if (!$saved)
        {
            return response()->json([
                'status' => 400,
                'msg' => 'Could not update order data'
            ]);
        }

        return response()->json([
            'status' => 200,
            'msg' => 'Ok'
        ]);
    }

    public function index(Request $request)
    {
        $current_user = auth()->user();
        if (!$current_user || !$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $users = User::where('id', '>', '0')->orderBy('id', 'desc')->limit(10)->get();
        $orders = Order::where('id', '>', '0')->orderBy('id', 'desc')->limit(10)->get();
        foreach($orders as $o)
        {
            $o->user;
        }
        $products = Product::where('id', '>', '0')->orderBy('id', 'desc')->limit(10)->get();

        $categories = Category::all();

        return view('admin.index', [
            'users' => $users,
            'orders' => $orders,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function orders_list(Request $request, $page = 1)
    {
        $current_user = auth()->user();
        if (!$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $orders = Order::where('id', '>', '0')->offset(($page - 1) * $this->items_per_page)
            ->orderBy('id', 'DESC')->limit($this->items_per_page)->get();

        $items_count = Order::all()->count();
        $last_page = intval(ceil($items_count / $this->items_per_page));

        return view('admin.orders', [
            'orders' => $orders,
            'last_page' => $last_page,
            'active_page' => $page,
        ]);
    }

    public function users_list(Request $request, $page = 1)
    {
        $current_user = auth()->user();
        if (!$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $users = User::where('id', '>', '0')->offset(($page - 1) * $this->items_per_page)
            ->orderBy('id', 'DESC')->limit($this->items_per_page)->get();

        $items_count = User::all()->count();
        $last_page = intval(ceil($items_count / $this->items_per_page));

        return view('admin.users', [
            'users' => $users,
            'last_page' => $last_page,
            'active_page' => $page,
        ]);
    }

    public function products_list(Request $request, $page = 1)
    {
        $current_user = auth()->user();
        if (!$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $products = Product::where('id', '>', '0')->offset(($page - 1) * $this->items_per_page)
            ->orderBy('id', 'DESC')->limit($this->items_per_page)->get();

        $items_count = Product::all()->count();
        $last_page = intval(ceil($items_count / $this->items_per_page));

        $categories = Category::all();

        return view('admin.products', [
            'products' => $products,
            'last_page' => $last_page,
            'active_page' => $page,
            'categories' => $categories,
        ]);
    }

    public function order_delete(Request $request, $id)
    {
        $current_user = auth()->user();
        if (!$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $deleted = Order::destroy($id);
        return back();
    }

    public function user_delete(Request $request, $id)
    {
        $current_user = auth()->user();
        if (!$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $deleted = User::destroy($id);
        return back();
    }

    public function product_delete(Request $request, $id)
    {
        $current_user = auth()->user();
        if (!$current_user->isAdmin())
        {
            return redirect()->route('admin-login');
        }

        $deleted = Product::destroy($id);
        return back();
    }

    public function login(Request $request)
    {
        return view('auth.admin.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
        ]);

        $logged_in = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$logged_in)
        {
            return redirect()->route('admin-login')->withErrors($validator);
        }

        $current_user = auth()->user();
        if (!$current_user->isAdmin())
        {
            auth()->logout();
            return redirect()->route('admin-login');
        }

        return redirect()->route('admin-dashboard');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('admin-login');
    }

}
