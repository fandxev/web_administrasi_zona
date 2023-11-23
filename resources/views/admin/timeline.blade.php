@extends('layouts.app')

@section('css_js')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Timeline Zona Media Group</span>
                        <div>
                            <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
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
                                <div class="col-md-12 mb-2 d-flex">
                                    <select class="form-select" name="pegawai" aria-label="Default select example">
                                        <option value="" selected>Pilih nama pegawai</option>
                                        @foreach ($pegawai as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-select" name="status" aria-label="Default select example">
                                        <option value="" selected>Status</option>
                                        <option value="datang">Masuk</option>
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
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Timeline</th>
                                </tr>
                                @foreach ($timeline as $item)
                                    <tr class="{{ $item->status == 'datang' ? 'bg-info' : 'bg-light' }}">
                                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->status == 'datang' ? 'Masuk' : 'Pulang' }}</td>
                                        <td>{{ $item->description }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{ $timeline->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
