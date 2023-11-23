@extends('layouts.app')

@section('css_js')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Timeline Zona Media Group</span>
                        <a href="{{ route('checklog') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>

                    <div class="card-body">
                        <h4>Timeline {{ $status == 'datang' ? 'Datang' : 'Pulang' }}</h4><br>
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
                        <div class="input-group mb-3 {{ $status == 'datang' ? 'd-none' : '' }}">
                            <input type="text" class="form-control" id="check" placeholder="✔️" aria-label="✔️"
                                aria-describedby="button-addon2" value="✔️">
                            <button class="btn btn-secondary btn-sm" type="button" id="button-addon2"
                                onclick="copyToClipboard()">Salin</button>
                        </div>
                        <form action="{{ route('timeline.store') }}" method="post" class="mb-3">
                            @csrf
                            <input type="hidden" name="status" value="{{ $status }}">
                            <div class="mb-3">
                                <label for="description" class="form-label">Timeline Deskripsi</label>
                                <textarea name="description" class="form-control" id="description" cols="30"
                                    rows="10">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="badge bg-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                        </form>

                        @if ($timeline != null)
                            <div class="card">
                                <div class="card-header">
                                    Timeline hari ini
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-item-date">
                                                {{ $timeline->created_at->format('d M Y H:i') }}
                                            </div>
                                            <div class="timeline-item-divider"></div>
                                            <div class="timeline-item-content">
                                                <div class="timeline-item-content-title">
                                                    {!! $timeline->description !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("check");
            copyText.select();
            document.execCommand("copy");
        }
    </script>
@endsection
