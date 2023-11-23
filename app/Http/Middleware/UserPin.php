<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserPin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if($request->has('pin')){
        //     $validate = Validator::make($request->all(), [
        //         'pin' => 'required|string',
        //     ]);

        //     if($validate->fails()){
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Pin tidak valid',
        //         ]);
        //     }
        //     $user = User::where('pin', $request->pin)->first();
        //     if(!$user){
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Pin tidak valid',
        //         ]);
        //     }
        //     return $next($request);
        // }else{
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Pin tidak valid',
        //     ]);
        // }
        return $next($request);
    }
}