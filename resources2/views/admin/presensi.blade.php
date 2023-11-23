@extends('layouts.app')

@section('css_js')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Presensi Pegawai Zona Media Group</span>
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>

                    <div class="card-body">
                        <form action="" method="get" class="mb-3">
                            <div class="row">
                                {{-- <div class="col-md-6 mb-2">
                                    <div class=" datepicker">
                                        <label for="datepicker" class="form-label">Select a date</label>
                                        <input type="text" name="tanggal" class="form-control" id="datepicker" />
                                    </div>
                                </div> --}}
                                <div class="col-12 mb-2 d-flex">
                                    <select class="form-select" name="pegawai" aria-label="Default select example">
                                        <option value="" selected>Pilih nama pegawai</option>
                                        @foreach ($pegawai as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-select" name="status" aria-label="Default select example">
                                        <option value="" selected>Status</option>
                                        <option value="masuk">Masuk</option>
                                        <option value="pulang">Pulang</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary ms-2">Filter</button>
                                </div>
                            </div>
                        </form>

                        <style>
                            table,
                            th,
                            td {
                                border: 1px solid black;
                                border-collapse: collapse;
                                padding: 0px 10px;
                            }

                        </style>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Nama</th>
                                    <th>Jam Presensi</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th>Total Jam Kerja</th>
                                    <th>Jam Masuk Besok</th>
                                    <th>Kresensi</th>
                                    <th>Tanggal</th>
                                    <th>Hapus</th>
                                </tr>
                                @foreach ($presensi as $item)
                                    <tr class="{{ $item->status == 'masuk' ? 'bg-info' : 'bg-light' }}">
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->jam }}</td>
                                        <td>
                                            <img src="{{ $item->foto }}" alt="" width="100">
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->jam_kerja }}</td>
                                        <td>{{ $item->jam_masuk_besok }}</td>
                                        <td>{{ $item->status == 'masuk' ? $item->presensi_status : '-' }}</td>
                                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('presensi.destroy', ['presensi' => $item->id]) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus?')" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{ $presensi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
@endsection
