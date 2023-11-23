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
                        <div>
                            <a href="{{ route('user.create') }}" class="btn btn-info btn-sm">Tambah</a>
                            <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <style>
                            table,
                            th,
                            td {
                                border: 1px solid black;
                                border-collapse: collapse;
                                padding: 0px 10px;
                            }

                        </style>
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <th>NIP</th>
                            </tr>
                            @foreach ($pegawai as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->nip }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $pegawai->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
