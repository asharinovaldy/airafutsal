@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="my-3">
        <h2 class="mb-5">Jadwal Saya</h2>
         <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Sewa Fasilitas Aira Futsal
        </button>
            <div class="table-responsive my-3">
                <table class="table table-striped table-bordered" id="mySchedulesTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order ID</th>
                            <th>Lapangan</th>
                            <th>Nama</th>
                            <th>Jam Booking</th>
                            <th>Durasi</th>
                            <th>Tanggal Booking</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Sewa Fasilitas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.schedules.store') }}" method="post">
            @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="field" class="form-label">Pilih Lapangan</label>
                                <select name="field" id="field" class="form-select" required>
                                    @foreach ($fields as $field)
                                        <option value="{{ $field->id }}"> {{ $field->field_name }} | Rp. {{ number_format($field->price) }} per jam</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="booking_name" class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control" name="booking_name" id="booking_name" placeholder="Nama Individu atau Nama Tim" required>
                            </div>
                            <div class="mb-3">
                                <label for="booking_date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                 @php
                                    $timestamps = ['08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];

                                    date_default_timezone_set('Asia/Makassar');
                                    $currentTime = date('H');
                                @endphp
                                <label for="booking_time" class="form-label">Waktu Mulai</label>
                                <select name="booking_time" id="booking_time" class="form-select" required>
                                    @foreach ($timestamps as $time)
                                        <option value="{{ $time }}:00" id="opt{{ $time }}"> {{ $time }}:00</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="duration" class="form-label">Durasi (Jam)</label>
                                <input type="number" class="form-control" name="duration" id="duration" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="additional" class="form-label">Mau sewa sepatu atau sewa bola? </label>
                                <select name="additional" id="additional" class="form-select" onchange="showAdditionalOrder()">
                                    <option value=""  selected>Pilih</option>
                                    <option value="boot">Sepatu</option>
                                    <option value="ball">Bola</option>
                                    <option value="both">Semuanya</option>
                                </select>
                            </div>
                            <div id="form-boots">
                                <div class="mb-3">
                                    <label for="boots" class="form-label">Pilih Sepatu (Ready Stock)</label>
                                    <select name="boots" id="boots" class="form-select" onchange="selectedBoots()">
                                        <option value="">Pilih tipe sepatu</option>
                                        @foreach ($boots as $boot)
                                            @if ($boot->stock > 0)
                                                <option value="{{ $boot->id }}"> {{ $boot->name }} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="row my-2">
                                        <div class="col-lg-5 col-sm-12">
                                            <img src="" alt="" srcset="" id="boots-image" height="120">
                                        </div>
                                        <div class="col-lg-7 col-sm-12">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Ukuran</td>
                                                    <td id="boots-size"></td>
                                                </tr>
                                                <tr>
                                                    <td>Harga Sewa</td>
                                                    <td id="boots-price"></td>
                                                </tr>
                                                <tr>
                                                    <td>Stok Tersedia</td>
                                                    <td id="boots-stock"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="quantity_boots">Quantity</label>
                                        <input type="number" class="form-control" name="quantity_boots" id="quantity_boots">
                                    </div>
                                </div>
                            </div>
                            <div id="form-balls">
                                <div class="mb-3">
                                    <label for="balls" class="form-label">Pilih Bola</label>
                                    <select name="balls" id="balls" class="form-select" onchange="selectedBalls()">
                                        <option value="">Pilih tipe bola</option>
                                        @foreach ($balls as $ball)
                                            <option value="{{ $ball->id }}"> {{ $ball->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class="row my-2">
                                        <div class="col-lg-5 col-sm-12">
                                            <img src="" alt="" srcset="" id="balls-image" height="120">
                                        </div>
                                        <div class="col-lg-7 col-sm-12">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Harga Sewa</td>
                                                    <td id="balls-price"></td>
                                                </tr>
                                                <tr>
                                                    <td>Stok Tersedia</td>
                                                    <td id="balls-stock"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="quantity_balls">Quantity</label>
                                    <input type="number" class="form-control" name="quantity_balls" id="quantity_balls">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="payment" class="form-label">Pembayaran</label>
                            <select name="payment" id="payment" class="form-select">
                                <option value="" disabled>Pilih metode pembayaran</option>
                                <option value="Cash">Cash</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Booking</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">

        $(document).ready(function(){
            let id = 1
            $('#mySchedulesTable').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ajax: {
                    url: '{{ url('user/data') }}',
                    type: 'GET',
                    dataType: 'JSON',
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'prefix', name: 'prefix' },
                    { data: 'field_id', name: 'field_id' },
                    // { data: 'user_id', name: 'user_id' },
                    { data: 'name', name: 'name' },
                    { data: 'booking_time', name: 'booking_time'},
                    { data: 'duration', name: 'duration', render:function(data){
                        return `${data} jam`
                    } },
                    { data: 'booking_date', name: 'booking_date' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            })
        })

        const selectedBoots = () => {
            // let bootsForm = document.getElementById('boots')
            // let bootsId = bootsForm.value

            let bootsId = $('#boots').find(':selected').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "GET",
                url: `get-data-boots/${bootsId}`,
                success: (data) => {
                    $('#boots-image').attr('src', `{{ Storage::url('images/${data.data.image}') }}`)
                    $('#boots-size').html(data.data.size)
                    $('#boots-price').html(data.data.price)
                    $('#boots-stock').html(data.data.stock)
                }
            })
        }

        const selectedBalls = () => {
            // let bootsForm = document.getElementById('boots')
            // let bootsId = bootsForm.value

            let ballsId = $('#balls').find(':selected').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "GET",
                url: `get-data-balls/${ballsId}`,
                success: (data) => {
                    $('#balls-image').attr('src', `{{ Storage::url('images/${data.data.image}') }}`)
                    $('#balls-price').html(data.data.price)
                    $('#balls-stock').html(data.data.stock)
                }
            })
        }

        const showAdditionalOrder = () => {
            let selected = $('#additional').find(':selected').val();

            if (selected === 'boot'){
                $('#form-balls').hide(500);
                $('#form-boots').show(500);
            }
            else if (selected === 'ball'){
                $('#form-balls').show(500);
                $('#form-boots').hide(500);
            }
            else if (selected === 'both'){
                $('#form-balls').show(500);
                $('#form-boots').show(500);
            }else{
                return 'not found!';
            }
        }

    </script>
@endsection
