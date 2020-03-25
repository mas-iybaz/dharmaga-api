<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'User Not Found!',
            ], 404);
        } else {
            if (Hash::check($request->password, $user->password)) {
                $api_token = Str::random(16);

                $user->update(['api_token' => $api_token]);

                return response()->json([
                    'status' => 'SUCCESS',
                    'api_token' => $api_token
                ], 200);
            } else {
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'Password do not match!'
                ], 401);
            }
        }
    }
}
