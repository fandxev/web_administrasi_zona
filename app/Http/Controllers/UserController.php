<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = User::where('role', 'pegawai')->paginate(15);
        return view('admin.user', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user_create');
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
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:users,nip',
            // 'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->nip = $request->nip;
        // $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'pegawai';
        $user->save();
        if($user){
            return redirect()->route('user.create')->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->route('user.create')->with('error', 'Data gagal ditambahkan');
        }
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

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // // /**
    // //  * Remove the specified resource from storage.
    // //  *
    // //  * @param  int  $id
    // //  * @return \Illuminate\Http\Response
    // //  */
    // // public function destroy($id)
    // // {
    // //     //
    // // }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user_edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->nip = $request->nip;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        if ($user) {
            return redirect()->route('user.index')->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->route('user.index')->with('error', 'Data gagal diubah');
        }
    }

    public function akun()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('akun_edit', compact('user'));
    }

    public function akun_update(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $validate = $request->validate([
            'password' => 'nullable|string|min:6',
            'confirm' => 'nullable|string|min:6|same:password',
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        if ($user) {
            return redirect()->back()->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Data gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Data tidak ditemukan');
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }


}