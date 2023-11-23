<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->pegawai != '' && $request->status != '') {
            $pegawai = $request->pegawai;
            $status = $request->status;
            $timeline = Timeline::join('users', 'users.id', '=', 'timelines.user_id')
            ->where('user_id', $pegawai)
            ->where('status', $status)
            ->orderBy('created_at', 'DESC')
            ->select('timelines.*', 'users.name')
            ->paginate(50);
        }else if($request->pegawai != '' && $request->status == '') {
            $pegawai = $request->pegawai;
            $timeline = Timeline::join('users', 'users.id', '=', 'timelines.user_id')
            ->where('user_id', $pegawai)
            ->orderBy('created_at', 'DESC')
            ->select('timelines.*', 'users.name')
            ->paginate(50);
        }else if($request->pegawai == '' && $request->status != '') {
            $status = $request->status;
            $timeline = Timeline::join('users', 'users.id', '=', 'timelines.user_id')
            ->where('status', $status)
            ->orderBy('created_at', 'DESC')
            ->select('timelines.*', 'users.name')
            ->paginate(50);
        }else {
            $timeline = Timeline::join('users', 'users.id', '=', 'timelines.user_id')
            ->orderBy('created_at', 'DESC')
            ->select('timelines.*', 'users.name')
            ->paginate(50);
        }
        $pegawai = User::where('role', 'pegawai')->get();
        $data = [
            'timeline' => $timeline,
            'pegawai' => $pegawai,
        ];
        // dd($timeline);
        return view('admin.timeline', $data);
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
        $validate = $request->validate([
            'description' => 'required|string',
        ]);
        $data = [
            'user_id' => auth()->user()->id,
            'description' => $request->description,
            'status' => $request->status,
        ];
        $timeline = Timeline::create($data);
        if($timeline){
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function show(Timeline $timeline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function edit(Timeline $timeline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Timeline $timeline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timeline $timeline)
    {
        //
    }

    public function timeline(Request $request, $status){
        $date = Carbon::now()->format('Y-m-d');
        $timeline = Timeline::where('user_id', auth()->user()->id)->where('status', $status)->where('created_at', 'like', "%$date%")->orderBy('created_at', 'DESC')->first();
        return view('pegawai.timeline', [
            'status' => $status,
            'timeline' => $timeline,
        ]);
    }

}