<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Twilio\Rest\Client;

use App\Models\User;

class VerifyController extends Controller
{
    public function start_verification(Request $request)
    {
        $sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $verify_service_sid = env("TWILIO_VERIFY_SERVICE_SID");

        $phone = $request->phone;

        $twilio = new Client($sid, $token);

        $verification = $twilio->verify->v2->services($verify_service_sid)
            ->verifications
            ->create($phone, "sms");

        if ($verification->status == 'pending')
        {
            return response()->json([
                'status' => 200,
                'msg' => 'ok'
            ]);
        } else {
            return response()->json([
                'status' => $verification->status,
                'msg' => $verification->message,
                'code' => $verification->code
            ]);
        }
    }

    public function verify_code(Request $request)
    {
        $sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $verify_service_sid = env("TWILIO_VERIFY_SERVICE_SID");

        $code = $request->code;
        $phone = $request->phone;

        $twilio = new Client($sid, $token);

        $verification_check = $twilio->verify->v2->services($verify_service_sid)
            ->verificationChecks
            ->create($code, // code
                    ["to" => $phone]
            );

        if ($verification_check->status == 'approved')
        {
            $constructed_pass = '';
            $constructed_email = '';

            if (str_starts_with($phone, '+'))
            {
                $constructed_email = substr($phone, 1, 100) . '@lavka.com';
            } else {
                $constructed_email = $phone . '@lavka.com';
            }

            $raw_pass = '937#' . $constructed_email . '@218';
            $constructed_pass = Hash::make($raw_pass);

            $credentials = [
                'email' => $constructed_email,
                'password' => $raw_pass
            ];

            $possible_user = User::where('email', $constructed_email)->first();
            if ($possible_user)
            {
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
            } else {
                $new_user = new User;
                $new_user->email = $constructed_email;
                $new_user->phone = $phone;
                $new_user->password = $constructed_pass;

                $saved = $new_user->save();
                if (!$saved)
                {
                    return response()->json([
                        'status' => 400,
                        'msg' => 'unable to store data'
                    ]);
                }

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

        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'invalid code'
            ]);
        }
    }
}
