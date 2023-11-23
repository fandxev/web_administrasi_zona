@foreach ($presensi as $data)
    <img src="{{ asset('files/images/' . $data->foto_awal_presensi)}}">
    <img src="{{ asset('files/images/' . $data->foto_akhir_presensi)}}">
@endforeach
