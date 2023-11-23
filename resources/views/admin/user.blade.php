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
                                <th>Aksi</th> {{-- Added column for actions --}}
                            </tr>
                            @foreach ($pegawai as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>
                                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
<form action="{{ route('destroy', $item->id) }}" method="post" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
</form>

                                    </td>
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
