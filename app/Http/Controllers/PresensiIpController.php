<?php

namespace App\Http\Controllers;

use App\Models\PresensiIp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PresensiIpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('atur_ip');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'password' => 'required|min:6',
        ]);
        $ip = parent::getIp();
        $cekUser = User::where('nip', 'admin')->first();
        if(Hash::check($request->password, $cekUser->password)){
            $checkPresensiIp = PresensiIp::where('ip', $ip)->where('created_at', Carbon::today()->toDateString())->first();
            if($checkPresensiIp){
                return redirect()->back()->with('success', 'IP sudah terdaftar');
            }
            PresensiIp::create([
                'ip' => $ip,
            ]);
            return redirect()->route('welcome')->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->back()->with('success', 'Password salah');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PresensiIp  $presensiIp
     * @return \Illuminate\Http\Response
     */
    public function show(PresensiIp $presensiIp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PresensiIp  $presensiIp
     * @return \Illuminate\Http\Response
     */
    public function edit(PresensiIp $presensiIp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresensiIp  $presensiIp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PresensiIp $presensiIp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresensiIp  $presensiIp
     * @return \Illuminate\Http\Response
     */
    public function destroy(PresensiIp $presensiIp)
    {
        //
    }

}