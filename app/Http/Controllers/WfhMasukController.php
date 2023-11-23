<?php

namespace App\Http\Controllers;

use App\Models\WfhMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WfhMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if($request->has('user_id')){
            $validate = $request->validate([
                'user_id' => 'required',
                'jam' => 'required|string',
            ]);
            $user_id = $request->user_id;
            }else{
                $validate = $request->validate([
                    'jam' => 'required|string',
                ]);
                $user_id = auth()->user()->id;
            }
            
            $date = Carbon::now()->format('Y-m-d');
            $cek_wfh_masuk = WfhMasuk::where('user_id', $user_id)->where('tanggal', 'LIKE', $date)->first();
            $data = [
                'user_id' => $user_id,
                'jam' => ($request->jam == 'lainnya' ? $request->jam_lain : $request->jam),
                'tanggal' => $date,
            ];
            if($cek_wfh_masuk){
                $udate = [
                    'jam' => ($request->jam == 'lainnya' ? $request->jam_lain : $request->jam),
                ];
                $wfh = $cek_wfh_masuk->update($udate);
            }else{
                $wfh = WfhMasuk::create($data);
            }
            if($wfh){
                return redirect()->back()->with('success', 'Data berhasil ditambahkan');
            }else{
                return redirect()->back()->with('error', 'Data gagal ditambahkan');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WfhMasuk  $wfhMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(WfhMasuk $wfhMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WfhMasuk  $wfhMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(WfhMasuk $wfhMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WfhMasuk  $wfhMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WfhMasuk $wfhMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WfhMasuk  $wfhMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(WfhMasuk $wfhMasuk)
    {
        //
    }

    public function wfh(){
        return view('pegawai.wfh');
    }
}