@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"><span>Edit jam wfh</span>
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>

                    <div class="card-body">
                        <h4>Edit jam wfh</h4>
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
                        Silahkan ubah waktu sebelum pukul 07:00, jika tidak maka waktu masuk otomatis pukul 08:00
                        <br><br>
                        Sekarang pukul <br>
                        <span id="date"></span>
                        <span id="clock"></span>
                        <br><br>
                        <form action="{{ route('wfh.store') }}" method="post" class="mb-3"
                            onsubmit="return validateForm()">
                            @csrf
                            {{-- <button type="button" id="start-camera">Start Camera</button> --}}
                            <div class="form-group mb-3">
                                <label for="">Jam masuk wfh</label><br>
                                <input type="radio" class="btn-check" name="jam" value="08:00" id="jam1"
                                    autocomplete="off" checked onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="jam1">08:00</label>
                                <input type="radio" class="btn-check" name="jam" value="09:00" id="jam2"
                                    autocomplete="off" onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="jam2">09:00</label>
                                <input type="radio" class="btn-check" name="jam" value="10:00" id="jam3"
                                    autocomplete="off" onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="jam3">10:00</label>
                                <input type="radio" class="btn-check" name="jam" value="11:00" id="jam4"
                                    autocomplete="off" onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="jam4">11:00</label>
                                <input type="radio" class="btn-check" name="jam" value="12:00" id="jam5"
                                    autocomplete="off" onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="jam5">12:00</label>
                                <input type="radio" class="btn-check" name="jam" value="13:00" id="jam6"
                                    autocomplete="off" onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="jam6">13:00</label>
                                <input type="radio" class="btn-check" name="jam" value="14:00" id="jam7"
                                    autocomplete="off" onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="jam7">14:00</label>
                                <input type="radio" class="btn-check" name="jam" value="15:00" id="jam8"
                                    autocomplete="off" onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="jam8">15:00</label>
                                <input type="radio" class="btn-check" name="jam" value="lainnya" id="lainnya"
                                    autocomplete="off" onclick="show(this)">
                                <label class="btn btn-outline-success btn-sm" for="lainnya">Lainnya</label>
                                <input type="text" name="jam_lainnya" style="display: none" class="form-control mt-2"
                                    placeholder="08:00" id="jam_lainnya">
                                <script>
                                    function show(e) {
                                        if (e.value == 'lainnya') {
                                            document.getElementById('jam_lainnya').style.display = 'block';
                                        } else {
                                            document.getElementById('jam_lainnya').style.display = 'none';
                                        }
                                    }
                                </script>
                            </div>
                            <div class="text-center">
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
