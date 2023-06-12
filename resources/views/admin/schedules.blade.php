@extends('layouts.admin.layouts')
@section('content')
    <div class="container">
        <div class="my-3">
        <h2 class="mb-5">Data Jadwal</h2>
         <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Pesan Lapangan
        </button>
            <div class="table-responsive my-3">
                <table class="table table-striped table-bordered" id="mySchedulesTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Prefix</th>
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Booking Lapangan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.schedules.store') }}" method="post">
            @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="field" class="form-label">Pilih Lapangan</label>
                        <select name="field" id="field" class="form-select" required>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}"> {{ $field->field_name }} </option>
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
                            $timestamps = ['08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23']
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
                    url: '{{ url('admin/data') }}',
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

    </script>
@endsection
