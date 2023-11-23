<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'nip' => ['NIP tidak ditemukan.'],
        ]);
    }

    public function nip()
    {
        return 'nip';
        // $login = request()->input('nip');
        // $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';   
        // request()->merge([$field => $login]);
        // return $field;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'nip'    => 'required',
            'password' => 'required',
        ]);
    
        $login_type = filter_var($request->input('nip'), FILTER_VALIDATE_EMAIL ) 
            ? 'email' 
            : 'nip';
    
        $request->merge([
            $login_type => $request->input('nip')
        ]);
    
        if (Auth::attempt($request->only($login_type, 'password'))) {
            return redirect()->route('home');
        }
    
        return redirect()->back()
            ->withInput()
            ->withErrors([
                'login' => 'These credentials do not match our records.',
            ]);
    } 
}