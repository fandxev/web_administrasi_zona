@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"><span>Presensi Karyawan Zona Media Group</span>
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>

                    <div class="card-body">
                        <h4>Presensi {{ $status }} WFH</h4>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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
                        Selamat datang, {{ $user->name }} <br>
                        Silahkan lakukan presensi anda di bawah ini.
                        <br><br>
                        Sekarang pukul <br>
                        <span id="date"></span>
                        <span id="clock"></span>
                        <br><br>
                        @if ($presensipulang == null)
                            <form action="{{ route('checklogwfh.store') }}" method="post" class="mb-3"
                                onsubmit="return validateForm()">
                                @csrf
                                <div class="form-group mb-3 text-center">
                                    <label for="">Foto Diri</label> <br>
                                    <video id="video" style="width: 100%; height: auto " autoplay></video><br>
                                    {{-- <button type="button" id="click-photo" class="btn btn-secondary">Ambil Foto</button><br> --}}
                                    <canvas id="canvas" style="display: none; width: 100%; height: auto "></canvas>
                                    <input type="hidden" id="foto" name="foto">
                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <button type="submit" class="btn btn-primary">Kirim presensi
                                        {{ $status }}</button>
                                </div>
                            </form>
                        @endif
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
                            <table class="table ">
                                <tr>
                                    <th>Jam Presensi</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th>Total Jam Kerja</th>
                                    <th>Presensi</th>
                                    <th>Tanggal</th>
                                    <th>Timeline</th>
                                </tr>
                                @foreach ($presensi as $item)
                                    <tr>
                                        <td>{{ $item->jam }}</td>
                                        <td>
                                            <img src="{{ $item->foto }}" alt="" width="100">
                                        </td>
                                        <td>{{ ucfirst($item->status) }}</td>
                                        <td>{{ $item->jam_kerja }}</td>
                                        <td>{{ $item->status == 'masuk' ? ucfirst($item->presensi_status) : '-' }}</td>
                                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                        <td><a
                                                href="{{ $item->status == 'masuk' ? route('timeline', ['status' => 'datang']) : route('timeline', ['status' => 'pulang']) }}">
                                                Isi Timeline</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // let camera_button = document.querySelector("#start-camera");
        let video = document.querySelector("#video");
        let click_button = document.querySelector("#click-photo");
        let canvas = document.querySelector("#canvas");
        let foto = document.querySelector("#foto");

        // camera_button.addEventListener('click', async function() {
        //     let stream = await navigator.mediaDevices.getUserMedia({
        //         video: true,
        //         audio: false
        //     });
        //     video.srcObject = stream;
        // });
        document.addEventListener('DOMContentLoaded', async function() {
            let stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            });
            video.srcObject = stream;
        })

        function validateForm() {
            const video = document.getElementById('video');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
            let image_data_url = canvas.toDataURL('image/jpeg');

            // data url of the image
            // console.log(image_data_url);
            foto.value = image_data_url;
        }
    </script>
    <script type="text/javascript">
        function showTime() {
            var a_p = "";
            var today = new Date();
            var curr_hour = today.getHours();
            var curr_minute = today.getMinutes();
            var curr_second = today.getSeconds();
            if (curr_hour < 12) {
                a_p = "AM";
            } else {
                a_p = "PM";
            }
            if (curr_hour == 0) {
                curr_hour = 12;
            }
            if (curr_hour > 12) {
                curr_hour = curr_hour - 12;
            }
            curr_hour = checkTime(curr_hour);
            curr_minute = checkTime(curr_minute);
            curr_second = checkTime(curr_second);
            document.getElementById('clock').innerHTML = curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        setInterval(showTime, 500);
        //
    </script>

    <!-- Menampilkan Hari, Bulan dan Tahun -->
    <br>
    <script type='text/javascript'>
        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'November', 'Desember'
        ];
        var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth();
        var thisDay = date.getDay(),
            thisDay = myDays[thisDay];
        var yy = date.getYear();
        var year = (yy < 1000) ? yy + 1900 : yy;
        document.getElementById('date').innerHTML = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
        //

        // navigator.geolocation.getCurrentPosition(function(location) {
        //     document.getElementById('latitude').value = location.coords.latitude;
        //     document.getElementById('longitude').value = location.coords.longitude;
        //     // console.log(location.coords.latitude);
        //     // console.log(location.coords.longitude);
        //     // console.log(location.coords.accuracy);
        // });
    </script>
@endsection
