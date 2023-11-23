@extends('layouts.app')

@section('css_js')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between">
                        <span>Akun Zona Media Group</span>
                        <div>
                            <a href="#tutorial" class="">Tutorial tambah Wifi</a>
                            <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('wifi.store') }}" method="post" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Wifi</label>
                                <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="badge bg-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="ssid" class="form-label">SSID</label>
                                <input type="text" name="ssid" class="form-control" id="ssid" value="{{ old('ssid') }}">
                                @error('ssid')
                                    <div class="badge bg-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                        </form>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table ">
                                <tr>
                                    <th>Nama Wifi</th>
                                    <th>SSID</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                @foreach ($wifi as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->ssid }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <form action="{{ route('wifi.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                @if ($item->status == 'active')
                                                    <input type="submit" name="status" value="nonactive" class="btn btn-danger">
                                                @else
                                                    <input type="submit" name="status" value="active" class="btn btn-primary">
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Cara menambah SSID wifi</div>
                    <div class="card-body">
                        <p>Ini adalah tutorial menambah ssid baru jika ada wifi baru atau jika muncul pesan wifi tidak di temukan</p>
                        <h4>Langkah-langkah</h4>
                        <ol>
                            <li>
                                <b>buka cmd terlebih dahulu</b>
                                <img src="{{ asset('img/1.png') }}" alt="" class="img-fluid">
                            </li>
                            <li>
                                <b>Ketikkan "netsh wlan show interfaces" lalu tekan enter</b>
                                <img src="{{ asset('img/2.png') }}" alt="" class="img-fluid">
                            </li>
                            <li>
                                <b>Silahkan cari BSSID lalu copy</b>
                                <img src="{{ asset('img/3.png') }}" alt="" class="img-fluid">
                            </li>
                            <li>
                                <b>Tambahkan pada list wifi di website administrasi</b>
                                <img src="{{ asset('img/4.png') }}" alt="" class="img-fluid">
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
