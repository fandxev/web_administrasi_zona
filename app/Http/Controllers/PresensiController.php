<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\PresensiIp;
use App\Models\User;
use App\Models\WfhMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $presensi = Presensi::orderBy('created_at', 'DESC')->get();
        $pegawai = User::where('role', 'pegawai')->get();
        // dd($request->all());

        $presensi = new Presensi();
        $presensi->select('presensis.*', 'users.name');
        $presensi->join('users', 'users.id', '=', 'presensis.user_id');
        if($request->status){
            $presensi->where('status', $request->status);
        }
        if($request->pegawai != ''){
            $presensi->where('user_id', $request->pegawai);
        }
        if($request->tipe != ''){
            $presensi->where('tipe', $request->tipe);
        }
        $presensi->orderBy('created_at', 'DESC');
        $presensi->paginate(50);
        // if($request->status != '' && $request->pegawai != '') {
        //     $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
        //     $user = $request->pegawai;
        //     $status = $request->status;
        //     $presensi = Presensi::join('users', 'users.id', '=', 'presensis.user_id')
        //     // ->where('created_at', 'like', "%$tanggal%")
        //     ->where('user_id', $user)
        //     ->where('status', $status)
        //     ->select('presensis.*', 'users.name')
        //     ->orderBy('created_at', 'DESC')
        //     ->paginate(50);
        // }else if($request->status != '' && $request->pegawai == '') {
        //     $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
        //     $presensi = Presensi::join('users', 'users.id', '=', 'presensis.user_id')
        //     ->where('status', $request->status)
        //     ->orderBy('created_at', 'DESC')
        //     ->select('presensis.*', 'users.name')
        //     ->paginate(50);
        // }else if($request->status == '' && $request->pegawai != '') {
        //     $user = $request->pegawai;
        //     $presensi = Presensi::join('users', 'users.id', '=', 'presensis.user_id')
        //     ->where('user_id', $user)
        //     ->orderBy('created_at', 'DESC')
        //     ->select('presensis.*', 'users.name')
        //     ->paginate(50);
        // }else {
        //     $presensi = Presensi::join('users', 'users.id', '=', 'presensis.user_id')
        //     ->orderBy('created_at', 'DESC')
        //     ->select('presensis.*', 'users.name')
        //     ->paginate(50);
        // }
        // dd($presensi->toSql());
        $data = [
            'presensi' => $presensi,
            'pegawai' => $pegawai
        ];
        return view('admin.presensi', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function show(presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function edit(presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(presensi $presensi)
    {
        // print_r(Request::all());
        // print_r($presensi);
        $presensi->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function checklog()
    {
        $user = auth()->user();
        $date = Carbon::now()->format('Y-m-d');
        $cekpresensi = Presensi::where('user_id', $user->id)->where('status', 'masuk')->where('tipe', 'wfo')->where('created_at', 'LIKE', "%$date%")->first();
        $presensi = Presensi::where('user_id', $user->id)->where('tipe', 'wfo')->where('created_at', 'LIKE', "%$date%")->get();
        $cekpresensipulang = Presensi::where('user_id', $user->id)->where('status', 'pulang')->where('tipe', 'wfo')->where('created_at', 'LIKE', "%$date%")->first();

        // dd($cekpresensi);
        $data = [
            'user' => auth()->user(),
            'status' => ($cekpresensi == null ? 'Masuk' : 'Pulang'),
            'presensi' => $presensi,
            'presensipulang' => $cekpresensipulang
        ];
        return view('pegawai.checklog', $data);
    }

    public function checklog_store(Request $request)
    {
        $user = auth()->user();
        $datetime = Carbon::now()->format('Y-m-d H:i:s');
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i:s');
        $dateyesterday = Carbon::yesterday()->format('Y-m-d');
        $cekpresensi = Presensi::where('user_id', $user->id)->where('status', 'masuk')->where('tipe', 'wfo')->where('created_at', 'LIKE', "%$date%")->first();
        $yesterdaypresensi = Presensi::where('user_id', $user->id)->where('tipe', 'wfo')->orderBy('created_at', 'DESC')->first() ?? "08:00";
        $ip = parent::getIp();
        $cekip = PresensiIp::where('ip', $ip)->where('created_at', 'LIKE', "%" . Carbon::today()->toDateString() . "%")->first();
        // dd($cekip);
        if($cekip == null) {
            return redirect()->back()->with('error', 'IP anda tidak terdaftar, apakah anda tidak menggunakan wifi kantor? silahkan hubungi admin');
        }
        
        $status = $cekpresensi == null ? 'masuk' : 'pulang';
        $presensi_status = strtotime($yesterdaypresensi != null ? date("H:i",strtotime('+1 minutes', strtotime($date . ' ' . $yesterdaypresensi->jam_masuk_besok))) : '08:01') > strtotime($time) || $status == 'pulang' ? 'Tepat Waktu' : 'Terlambat';
        $masuk_pukul = date("Y-m-d H:i:s",strtotime('-5 minutes', strtotime($date . ' ' . $yesterdaypresensi->jam_masuk_besok)));
        if($datetime < $masuk_pukul) {
            $timeExplode = explode('', $masuk_pukul);
            return redirect()->back()->with('error', 'Silahkan melakukakn presensi mulai pukul ' . $timeExplode[1]);
        }
        
        $this->validate($request, [
            'jam_masuk_besok' => 'required',
            'foto' => 'required',
        ]);
        
        // jam kerja masih error 0
        $jam_kerja = '00:00';
        if ($status == 'pulang') {
            $jam_kerja = date_diff(date_create($cekpresensi->jam), date_create($time))->format('%H:%i:%s');
        }
        $data = [
            'user_id' => $user->id,
            'jam' => $time,
            'jam_masuk_besok' => $request->jam_masuk_besok == 'lainnya' ? $request->jam_masuk_besok_lainnya : $request->jam_masuk_besok,
            'jam_kerja' => $jam_kerja,
            'status' => $status,
            'foto' => $request->foto,
            'device' => $request->userAgent(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'presensi_status' => $presensi_status,
            'tipe' => 'wfo',
        ];
        $insert = Presensi::create($data);
        if($insert) {
            return redirect()->back()->with('success', 'Berhasil Check In');
        }else {
            return redirect()->back()->with('error', 'Gagal Check In');
        }
    }

    public function checklogwfh(Request $request)
    {
        $user = auth()->user();
        $date = Carbon::now()->format('Y-m-d');
        $cekpresensi = Presensi::where('user_id', $user->id)->where('status', 'masuk')->where('tipe', 'wfh')->where('tipe', 'wfh')->where('created_at', 'LIKE', "%$date%")->first();
        $presensi = Presensi::where('user_id', $user->id)->where('tipe', 'wfh')->where('created_at', 'LIKE', "%$date%")->get();
        $cekpresensipulang = Presensi::where('user_id', $user->id)->where('status', 'pulang')->where('tipe', 'wfh')->where('created_at', 'LIKE', "%$date%")->first();

        // dd($cekpresensipulang);
        $data = [
            'user' => auth()->user(),
            'status' => ($cekpresensi == null ? 'Masuk' : 'Pulang'),
            'presensi' => $presensi,
            'presensipulang' => $cekpresensipulang
        ];
        return view('pegawai.checklogwfh', $data);
    }
// buat halaman wfh
    public function checklogwfh_store(Request $request)
    {
        $user = auth()->user();
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i:s');
        $dateyesterday = Carbon::yesterday()->format('Y-m-d');
        $cekpresensi = Presensi::where('user_id', $user->id)->where('status', 'masuk')->where('tipe', 'wfh')->where('created_at', 'LIKE', "%$date%")->first();
        // $yesterdaypresensi = Presensi::where('user_id', $user->id)->where('tipe', 'wfo')->where('created_at', 'LIKE', "%$dateyesterday%")->orderBy('created_at', 'DESC')->first();

        $cek_jam_wfh = WfhMasuk::where('user_id', $user->id)->where('created_at', 'LIKE', "%$date%")->first();

        $status = $cekpresensi == null ? 'masuk' : 'pulang';
        $presensi_status = strtotime($cek_jam_wfh != null ? date("H:i",strtotime('+1 minutes', strtotime($date . ' ' . $cek_jam_wfh->jam))) : '08:01') > strtotime($time) || $status == 'pulang' ? 'Tepat Waktu' : 'Terlambat';
        
        $this->validate($request, [
            'foto' => 'required',
        ]);
        
        $jam_kerja = '00:00';
        if ($status == 'pulang') {
            $jam_kerja = date_diff(date_create($cekpresensi->jam), date_create($time))->format('%H:%i:%s');
        }
        
        $data = [
            'user_id' => $user->id,
            'jam' => $time,
            'jam_masuk_besok' => '08:00',
            'jam_kerja' => $jam_kerja,
            'status' => $status,
            'foto' => $request->foto,
            'device' => $request->userAgent(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'presensi_status' => $presensi_status,
            'tipe' => "wfh",
        ];
        $insert = Presensi::create($data);
        if($insert) {
            return redirect()->back()->with('success', 'Berhasil Check In');
        }else {
            return redirect()->back()->with('error', 'Gagal Check In');
        }
    }

}