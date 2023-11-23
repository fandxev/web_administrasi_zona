<?php

namespace App\Http\Controllers;

use App\Models\Presensi2;
use App\Models\User;
use Illuminate\Http\Request;

class Presensi2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
       $pegawai = User::where('role', 'pegawai')->get();
   

       $presensi = Presensi2::select('presensi2s.*', 'users.name as user', 'wifis.nama as wifi');
       $presensi->join('users', 'users.id', 'presensi2s.user_id');
       $presensi->join('wifis', 'wifis.ssid', 'presensi2s.ssid');

       if(!empty($request->pegawai)){
           $presensi->where('user_id', $request->pegawai);
       }

       $presensi->orderBy('created_at', 'DESC');
       $result = $presensi->paginate(50);
 
       $data = [
           'presensi' => $result,
           'pegawai' => $pegawai
       ];
       return view('admin.presensi2', $data);
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
     * @param  \App\Models\Presensi2  $presensi2
     * @return \Illuminate\Http\Response
     */
    public function show(Presensi2 $presensi2)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presensi2  $presensi2
     * @return \Illuminate\Http\Response
     */
    public function edit(Presensi2 $presensi2)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presensi2  $presensi2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presensi2 $presensi2)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presensi2  $presensi2
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         PresensiGps::destroy($id);
        //$presensi2->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}