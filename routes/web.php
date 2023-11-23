<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');

//test tampil gambar
Route::get('/test-gambar',[App\Http\Controllers\PresensiGPSController::class, 'testTampilGambar']);

Route::resource('presensiIp', App\Http\Controllers\PresensiIpController::class);
Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'pegawai'])->name('homepegawai')->middleware('pegawai');

    Route::get('/checklog', [App\Http\Controllers\PresensiController::class, 'checklog'])->name('checklog')->middleware('pegawai');
    Route::post('/checklog/store', [App\Http\Controllers\PresensiController::class, 'checklog_store'])->name('checklog.store')->middleware('pegawai');
    Route::get('/timeline/{status}', [App\Http\Controllers\TimelineController::class, 'timeline'])->name('timeline')->middleware('pegawai');

    Route::get('/checklogwfh', [App\Http\Controllers\PresensiController::class, 'checklogwfh'])->name('checklogwfh')->middleware('pegawai');
    Route::post('/checklogwfh/store', [App\Http\Controllers\PresensiController::class, 'checklogwfh_store'])->name('checklogwfh.store')->middleware('pegawai');
    // buat halaman wfh

    Route::get('/akun', [App\Http\Controllers\UserController::class, 'akun'])->name('akun')->middleware('auth');
    Route::post('/akun', [App\Http\Controllers\UserController::class, 'akun_update'])->name('akun_update')->middleware('auth');

    Route::delete('/akun/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    
    Route::get('/wfh/set', [App\Http\Controllers\WfhMasukController::class, 'wfh'])->name('wfh.set')->middleware('pegawai');
    // Route::post('/wfh/set', [App\Http\Controllers\WfhMasukController::class, 'wfh_store'])->name('wfh.set.store')->middleware('pegawai');

    Route::resource('/presensi', App\Http\Controllers\PresensiController::class)->middleware('admin');
    Route::resource('/presensi2', App\Http\Controllers\Presensi2Controller::class)->middleware('admin');
    Route::resource('/presensi_gps', App\Http\Controllers\PresensiGPSController::class)->middleware('admin');
    Route::resource('/user', App\Http\Controllers\UserController::class)->middleware('admin');
    Route::resource('/wifi', App\Http\Controllers\WifiController::class)->middleware('admin');
    Route::resource('/timeline', App\Http\Controllers\TimelineController::class)->middleware('auth');
    Route::resource('/presensiwfh', App\Http\Controllers\PresensiWfhController::class)->middleware('pegawai');
    Route::resource('/wfh', App\Http\Controllers\WfhMasukController::class)->middleware('pegawai');
});
Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');
    dd("Cache Clear All");
});

Route::get('/files/{path}/{file}', function($path, $file) {
    if (Storage::disk('public')->exists($path . '/'. $file)) {
        $data = Storage::disk('public')->get($path . '/' . $file);
        $response = Response::make($data, 200);
        $response->headers->set('Content-Type', 'image/jpeg');
        return $response;
    }else{
        abort(404);
    }
})->name('getfile');