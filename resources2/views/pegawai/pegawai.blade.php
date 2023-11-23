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

                        Silahkan melakukan presensi pada menu Presensi dibawah ini.
                        <br>

                        <table class="table table-bordered ">
                            <tr>
                                <th>Jam masuk selanjutnya</th>
                                <td>
                                    @if ($yesterdaypresensi != null)
                                        {{ $yesterdaypresensi->jam_masuk_besok }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <a href="{{ route('checklog') }}" class="btn btn-primary btn-sm">Presensi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
