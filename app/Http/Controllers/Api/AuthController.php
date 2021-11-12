<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['signup', 'login']);
    } 

    //sign up
    public function signup(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'username'  => 'required|string|max:255',
            'phone'  => 'required|max:15',
            'address'  => 'required|string|max:255',
            'city'  => 'required|string',
            'country'  => 'required|string',
            'postcode'  => 'required|max:15',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'username'     => $request->username,
            'phone'     => $request->phone,
            'address'     => $request->address,
            'city'     => $request->city,
            'country'     => $request->country,
            'postcode'     => $request->postcode,
        ]);

        $token = JWTAuth::fromUser($user);

        if ($user) {
            return response()->json([
                'email' => $user->email,
                'token' => $token,
                'username' => $user->username
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    //login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email or Password is incorrect'
            ], 401);
        }
        return response()->json([
            'email' => auth()->guard('api')->user()->email,
            // 'user'    => auth()->guard('api')->user(),
            'token'   => $token,
            'username' => auth()->guard('api')->user()->username,
        ], 201);
    }

    //getuser
    public function getUser()
    {
        return response()->json([
            'success' => true,
            'user'    => auth()->user()
        ], 200);
    }
}
