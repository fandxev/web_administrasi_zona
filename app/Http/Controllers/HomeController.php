<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\PresensiIp;
use App\Models\WfhMasuk;
use App\Models\WfoMasuk;
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
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role == 'admin'){
            return view('admin.admin');
        }else if(Auth::user()->role == 'pegawai'){
            $yesterdaypresensi = Presensi::where('user_id', Auth::user()->id )->where('tipe', 'wfo')->orderBy('created_at', 'DESC')->first();
            $jam_masuk_wfh = WfhMasuk::where('user_id', Auth::user()->id)->where('tanggal', Carbon::now()->format('Y-m-d'))->first();
            $datetime = Carbon::now()->format('Y-m-d H:i:s');
            $date = Carbon::now()->format('Y-m-d');
            $edit_wfh = true;
            if($datetime > date('Y-m-d H:i:s', strtotime($date.' 07:00:00'))){
                $edit_wfh = false;
            }
            $data = [
                'yesterdaypresensi' => $yesterdaypresensi,
                'jam_masuk_wfh' => $jam_masuk_wfh,
                'edit_wfh' => $edit_wfh,
            ];
            return view('pegawai.pegawai', $data);
        }
    }

    public function pegawai()
    {
        return view('pegawai.pegawai', compact('jam_masuk_wfh'));
    }

    public function admin()
    {
        return view('admin.admin');
    }   

    public function welcome(Request $request)
    {
        $ip = parent::getIp();
        $presensiIp = PresensiIp::where('created_at', 'like', "%".Carbon::today()->toDateString() . "%")
        ->where('ip', $ip)->first();
        return view('welcome', compact('presensiIp'));
    }
}