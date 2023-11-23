@extends('layouts.app')

@section('css_js')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Akun Zona Media Group</span>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
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


                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" id="nama" value="{{ old('name', $user->name) }}">
                            @error('name')
                            <div class="badge bg-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="number" name="nip" class="form-control" id="nip" value="{{ old('nip', $user->nip) }}">
                            @error('nip')
                            <div class="badge bg-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" value="">
                            @error('password')
                            <div class="badge bg-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
