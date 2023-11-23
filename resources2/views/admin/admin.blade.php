@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Menu ini hanya untuk admin.
                        <br>
                        <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm">Akun</a>
                        <a href="{{ route('presensi.index') }}" class="btn btn-primary btn-sm">Presensi</a>
                        <a href="{{ route('timeline.index') }}" class="btn btn-primary btn-sm">Timeline</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
