<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;
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
        if($request->status != '' && $request->pegawai != '') {
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $user = $request->pegawai;
            $status = $request->status;
            $presensi = Presensi::join('users', 'users.id', '=', 'presensis.user_id')
            // ->where('created_at', 'like', "%$tanggal%")
            ->where('user_id', $user)
            ->where('status', $status)
            ->select('presensis.*', 'users.name')
            ->orderBy('created_at', 'DESC')
            ->paginate(50);
        }else if($request->status != '' && $request->pegawai == '') {
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $presensi = Presensi::join('users', 'users.id', '=', 'presensis.user_id')
            // ->where('created_at', 'like', "%$tanggal%")
            ->where('status', $request->status)
            ->orderBy('created_at', 'DESC')
            ->select('presensis.*', 'users.name')
            ->paginate(50);
        }else if($request->status == '' && $request->pegawai != '') {
            $user = $request->pegawai;
            $presensi = Presensi::join('users', 'users.id', '=', 'presensis.user_id')
            ->where('user_id', $user)
            ->orderBy('created_at', 'DESC')
            ->select('presensis.*', 'users.name')
            ->paginate(50);
        }else {
            $presensi = Presensi::join('users', 'users.id', '=', 'presensis.user_id')
            ->orderBy('created_at', 'DESC')
            ->select('presensis.*', 'users.name')
            ->paginate(50);
        }
        // dd($presensi);
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
        $cekpresensi = Presensi::where('user_id', $user->id)->where('status', 'masuk')->where('created_at', 'LIKE', "%$date%")->first();
        $presensi = Presensi::where('user_id', $user->id)->where('created_at', 'LIKE', "%$date%")->get();
        $cekpresensipulang = Presensi::where('user_id', $user->id)->where('status', 'pulang')->where('created_at', 'LIKE', "%$date%")->first();

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
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i:s');
        $dateyesterday = Carbon::yesterday()->format('Y-m-d');
        $cekpresensi = Presensi::where('user_id', $user->id)->where('status', 'masuk')->where('created_at', 'LIKE', "%$date%")->first();
        $yesterdaypresensi = Presensi::where('user_id', $user->id)->where('created_at', 'LIKE', "%$dateyesterday%")->orderBy('created_at', 'DESC')->first();

        $status = $cekpresensi == null ? 'masuk' : 'pulang';
        $presensi_status = strtotime($yesterdaypresensi != null ? $yesterdaypresensi->jam_masuk_besok : '08:00') > strtotime($time) || $status == 'pulang' ? 'Tepat Waktu' : 'Terlambat';
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
        ];
        $insert = Presensi::create($data);
        if($insert) {
            return redirect()->back()->with('success', 'Berhasil Check In');
        }else {
            return redirect()->back()->with('error', 'Gagal Check In');
        }
    }
}