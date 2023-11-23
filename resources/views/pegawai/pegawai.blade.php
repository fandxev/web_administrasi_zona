@extends('layouts.layout')

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

                        Silahkan melakukan presensi pada menu Presensi dibawah ini.
                        <br>

                        <table class="table table-bordered ">
                            <tr>
                                <th>Jam masuk WFO</th>
                                <td>
                                    @if ($yesterdaypresensi != null)
                                        {{ $yesterdaypresensi->jam_masuk_besok }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Jam masuk WFH</th>
                                <td>

                                    @if ($jam_masuk_wfh != null)
                                        {{ $jam_masuk_wfh->jam }}
                                        @if ($edit_wfh != false)
                                            <a href="{{ route('wfh.set') }}" class="btn btn-primary btn-sm">Ubah waktu</a>
                                        @endif
                                    @else
                                        @if ($edit_wfh != false)
                                            <a href="{{ route('wfh.set') }}" class="btn btn-primary btn-sm">Ubah waktu</a>
                                        @else
                                            08:00
                                        @endif
                                    @endif
                                    <br>
                                    <small class="text-muted">Silahkan ubah waktu sebelum pukul 07:00, jika tidak maka
                                        waktu masuk otomatis pukul 08:00</small>
                                </td>
                            </tr>
                        </table>
                        <a href="{{ route('checklog') }}" class="btn btn-primary btn-sm">Presensi WFO</a>
                        <a href="{{ route('checklogwfh') }}" class="btn btn-success btn-sm">Presensi WFH</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
