<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\PresensiIp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Presensi2;
use App\Models\Wifi;

class ApiPresensiController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checklog_store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'ssid' => 'required|string',
            'file' => 'required|file|image',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => '0',
                'message' => 'Data tidak lengkap',
                'error' => $validate->errors()
            ], 400);
        }

        $wifi = Wifi::where('ssid', $request->ssid)->where('status', 'active')->first();

        if(!$wifi){
            return response()->json([
                'status' => '0',
                'message' => 'WIFI tidak terdaftar. Pastikan melakukan presensi di WIFI yang telah ditentukan',
            ], 200);
        }

        $user = $request->user();
        $datetime = Carbon::now()->format('Y-m-d H:i:s');
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
        $dateyesterday = Carbon::yesterday()->format('Y-m-d');
        // $yesterdaypresensi = Presensi::where('user_id', $user->id)->orderBy('created_at', 'DESC')->first() ?? "08:00";
        $status = strtotime($date . ' 08:01') > strtotime($datetime) ? 'Tepat Waktu' : 'Terlambat';
        $path = $request->file('file')->store('public/images');
        $filename = explode('/',$path);
        $data = [
            'user_id' => $user->id,
            'jam_masuk' => $time,
            'jam_masuk_selanjutnya' => '08:00',
            'foto' => $filename[2],
            'ssid' => $request->ssid,
            'status' => $status,
        ];
        $insert = Presensi2::create($data);
        if($insert) {
            return response()->json([
                'status' => 1,
                'message' => 'Berhasil Check In'
            ], 200);
        }else {
            return response()->json([
                'status' => 0,
                'message' => 'Gagal Check In '
            ], 400);
        }
    }
    
    //validasi apakah token bearer sanctum masih valid atau tidak
    public function validateToken(){
        if(Auth('sanctum')->user()->id){
            return response()->json([
                'status' => 1,
                'message' => 'token valid'
                ],200);
        }
    }
    

}