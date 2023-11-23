<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(),[
    //         'pin' => 'required|integer|max:15',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json($validator->errors());       
    //     }

    //     $user = User::create([
    //         'pin' => $request->pin,
    //      ]);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()
    //         ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    // }

    public function login(Request $request)
    {
        if ($request->only('nip')){
            
            // $user = User::where('nip', $request->nip)->first();
            $user = User::where('nip', $request->nip)->where('status','active')->first();
            if($user){
            $token = $user->createToken('auth_token')->plainTextToken;
            
                return response()
                ->json(['status' => 1,
                    'message' => 'Success',
                    'access_token' => $token, 
                    'token_type' => 'Bearer', 
                    'user' => $user,
                ], 201);
            }else{
                return response()
                ->json(['status' => 0,'message' => 'User tidak ditemukan' ], 404);
            }
        }else{
            return response()
            ->json(['message' => 'Unauthorized'], 401);
        }
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 1,
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ], 201);
    }
}