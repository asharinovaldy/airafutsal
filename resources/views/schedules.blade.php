@extends('layouts.layouthome')
@section('content')
    <div class="container">
        <form method="GET">
            @csrf
            <div>
                <label for="datepicker" class="form-label">Pilih tanggal</label>
                <input type="date" class="form-control" name="date" id="datepicker" required>
            </div>
            <div class="mt-3">
                <label for="fields" class="form-label">Pilih lapangan</label>
                <select name="fields" id="fields" class="form-control" required>
                    <option value="" disabled>Pilih lapangan</option>
                    @foreach ($fields as $field)
                        <option value="{{ $field->id }}"> {{ $field->field_name }} </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary my-3">Cari Jadwal</button>
        </form>
        <div class="table-responsive my-5">
            <h2>Jadwal {{ $date }} </h2>
            <table class="table table-striped table-bordered table-hover">
            {{-- @dd($order) --}}
                <thead>
                    <tr>
                        @php
                            $timestamps = ['08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23']
                        @endphp

                        @foreach ($timestamps as $item)
                            <th> {{ $item }}:00 </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($timestamps as $item)
                            <th id="col{{$item}}"></th>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
       let data = {{ Js::from($orders) }}

       data.forEach(element => {
           let time = JSON.parse(element.booking_time)
           time.map(t => {
               let idCol = t.slice(0,2)
               let column = document.getElementById(`col${idCol}`).innerHTML = element.name
            })
       });

    </script>
@endsection
