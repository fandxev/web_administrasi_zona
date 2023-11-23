<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiGps;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PresensiGPSController extends Controller
{
    public function index()
    {
        //return PresensiGps::all();

        $pegawai = User::where('role', 'pegawai')->get();
   

        $presensi = PresensiGps::select('presensi_with_gps.*', 'users.name as user');
        $presensi->join('users', 'users.id', 'presensi_with_gps.user_id');
 
        if(!empty($request->pegawai)){
            $presensi->where('user_id', $request->pegawai);
        }
 
        $presensi->orderBy('created_at', 'DESC');
        $result = $presensi->paginate(50);
  
        $data = [
            'presensi' => $result,
            'pegawai' => $pegawai
        ];
        return view('admin.presensi_gps', $data);
    }

    public function show($id)
    {
        return PresensiGps::find($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Menangani unggahan gambar
        if ($request->hasFile('foto_awal_presensi')) {
            // $fotoAwalPath = $request->file('foto_awal_presensi')->store('public/images');
            // $data['foto_awal_presensi'] = Storage::url($fotoAwalPath);
            
            $path = $request->file('foto_awal_presensi')->store('public/images');
            $filename = explode('/',$path);
            $data['foto_awal_presensi'] = $filename[2];
        }

        if ($request->hasFile('foto_akhir_presensi')) {
            // $fotoAkhirPath = $request->file('foto_akhir_presensi')->store('public/images');
            // $data['foto_akhir_presensi'] = Storage::url($fotoAkhirPath);
            $path = $request->file('foto_akhir_presensi')->store('public/images');
            $filename = explode('/',$path);
            $data['foto_akhir_presensi'] = $filename[2];
        }

        $presensi = PresensiGps::create($data);

        return $presensi;
    }

    public function update(Request $request, $id)
    {
        $presensi = PresensiGps::find($id);
        $presensi->update($request->all());
        return $presensi;
    }


  /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresensiGps  $presensiGps
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PresensiGps::destroy($id);
        //$presensiGps->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
    

    public function testTampilGambar(){
        $presensi = PresensiGps::all();
        return view('test-gambar', ['presensi' => $presensi]);
    }

    public function test(){
        echo "ini test";
    }
}
