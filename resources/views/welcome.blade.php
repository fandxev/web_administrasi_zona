@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h1>Zona Media Group</h1>
                        <a class="btn btn-outline-dark" href="{{ route('login') }}">{{ __('Login') }}</a>
                        <br>
                        <br>
                        <a class="btn btn-primary" href="{{ asset('apps_zona_media_group.apk') }}">Download APK</a>
                        <a class="btn btn-primary" href="{{ asset('apps_zona_media_group2.apk') }}">Download APK V2</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
