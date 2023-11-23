<?php

namespace App\Http\Controllers;

use App\Models\Wifi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WifiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'wifi' => Wifi::get(),
        ];
        return view('admin.wifi', $data);
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
        $valitade = $request->validate([
            'nama' => 'string|required',
            'ssid' => 'string|required'
        ]);

        $data = [
            'nama' => $request->nama,
            'ssid' => $request->ssid,
        ];
        if(Wifi::create($data)){
            return redirect()->route('wifi.index')->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->route('wifi.index')->with('error', 'Data gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wifi  $wifi
     * @return \Illuminate\Http\Response
     */
    public function show(Wifi $wifi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wifi  $wifi
     * @return \Illuminate\Http\Response
     */
    public function edit(Wifi $wifi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wifi  $wifi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wifi $wifi)
    {
        $status = $request->status;
        $wifi->update(['status' => $status]);
        return redirect()->route('wifi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wifi  $wifi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wifi $wifi)
    {
        //
    }
}