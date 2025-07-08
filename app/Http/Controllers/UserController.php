<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Userr;
use Illuminate\Support\Facades\Hash;
use App\Models\Token;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // return response()->json([
        //     'token' => bin2hex(random_bytes(32)),
        // ], 200);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = Userr::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'message' => 'User already exits',
            ], 400);
        }

        $user = Userr::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        if (!$user) {
            return response()->json([
                'message' => 'User creation failed',
            ], 500);
        }

        $token_string = bin2hex(random_bytes(32));
        $token = Token::create([
            'token' => $token_string,
            'user_id' => $user->id,
            'is_active' => 1,

        ]);



        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token->token,
        ], 201);
    }


    public function getProfile(Request $request)
    {
        $token = $request->attributes->get('token');
        $user = Userr::find($token->user_id);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->attributes->get('token');

        $token->is_active = 0;
        $token->save();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);


        $user = Userr::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid email or password'
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ]);
        }

        $token_string = bin2hex(random_bytes(32));

        $token = Token::create([
            'token' => $token_string,
            'user_id' => $user->id,
            'is_active' => 1,
        ]);

        if (!$token) {
            return response()->json([
                'message' => 'Token is not created'

            ], 500);
        }

        return response()->json([
            'message' => 'Login Successful',
            'user' => $user,
            'token' => $token->token,

        ], 200);
    }
}
