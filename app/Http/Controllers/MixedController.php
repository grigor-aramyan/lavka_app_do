<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class MixedController extends Controller
{
    public function login_as_guest(Request $request)
    {
        $credentials = [
            'email' => 'guest443532@lavkaapp.com',
            'password' => 'secret88D'
        ];

        $logged_in = Auth::attempt($credentials);

        if (!$logged_in)
        {
            return response()->json([
                'status' => 400,
                'msg' => 'wrong credentials'
            ]);
        }

        return response()->json([
            'status' => 200,
            'msg' => 'ok'
        ]);
        
    }
}
