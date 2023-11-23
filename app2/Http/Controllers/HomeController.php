<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Auth::user());
        if(Auth::user()->role == 'admin'){
            return view('admin.admin');
        }else if(Auth::user()->role == 'pegawai'){
            $yesterdaypresensi = Presensi::where('user_id', Auth::user()->id )->orderBy('created_at', 'DESC')->first();
            $data = [
                'yesterdaypresensi' => $yesterdaypresensi
            ];
            return view('pegawai.pegawai', $data);
        }
    }

    public function pegawai()
    {
        return view('pegawai.pegawai');
    }

    public function admin()
    {
        return view('admin.admin');
    }   
}