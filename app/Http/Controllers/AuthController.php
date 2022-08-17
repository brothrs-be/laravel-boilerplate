<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function Register(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Store data in array
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];

            // Create & return user
            return User::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function Login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                //
                return response('Unauthorized', 401);
            }

            $user = Auth::user();

            $token = $user->createToken('token')->plainTextToken;

            $cookie = cookie('jwt', $token, 60 * 24); // 1day

            return response([
                'message' => 'Authorization succeeded',
                'token' => $token,
            ], 201)->withCookie($cookie);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function User()
    {
        return Auth::user();
    }

    public function Logout()
    {
        try {
            $cookie = Cookie::forget('jwt');

            return response('Logout succeeded')->withCookie($cookie);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
