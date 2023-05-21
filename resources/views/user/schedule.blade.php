@extends('layouts.app')
@section('content')
     <div class="container">
        <form method="GET">
            @csrf
            <div>
                <label for="datepicker" class="form-label">Pilih tanggal</label>
                <input type="date" class="form-control" name="date" id="datepicker" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="mt-3">
                <label for="fields" class="form-label">Pilih lapangan</label>
                <select name="fields" id="fields" class="form-control" required>
                    <option value="">Pilih lapangan</option>
                    @foreach ($fields as $field)
                        <option value="{{ $field->id }}"> {{ $field->field_name }} </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary my-3">Cari Jadwal</button>
        </form>
        <div class="table-responsive my-5">
            @if ($orders)
                {{-- parsing date to indonesian format --}}
                <h2 class="fw-bold">Jadwal {{ \Carbon\Carbon::parse($date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l, j F Y') }}, Lapangan {{ app('request')->input('fields') }} </h2>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            {{-- init timestamps variable --}}
                            @php
                                $timestamps = ['08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23']
                            @endphp

                            {{-- loop the table head using timestamps variable --}}
                            @foreach ($timestamps as $item)
                                <th> {{ $item }}:00 </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            {{-- loop the body of table based on timestamps variable --}}
                            @foreach ($timestamps as $item)
                                <td id="col{{$item}}" height='25'></th>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        // get data orders from controller
       let data = {{ Js::from($orders) }}

    //    looping data
       data.forEach(element => {
        // parsing the time
           let time = JSON.parse(element.booking_time)

        //    loop the array booking time
           time.map(t => {
            // slice it
               let idCol = t.slice(0,2)

               //    set value to the column when the column match between column id and booking time
               let column = document.getElementById(`col${idCol}`).innerHTML = element.name
            })
       });

    </script>
@endsection
