@extends('layouts.layouthome')
@section('content')
       <div class="container">
            <form action="">
                <div>
                    <label for="date" class="form-label">Pilih tanggal</label>
                    <input type="date" class="form-control" name="date" id="date">
                </div>
                <div class="mt-3">
                    <label for="fields" class="form-label">Pilih lapangan</label>
                    <select name="fields" id="fields" class="form-control">
                        <option value="" disabled>Pilih lapangan</option>
                        @foreach ($fields as $field)
                            <option value="{{ $field->id }}"> {{ $field->field_name }} </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary my-3">Cari Jadwal</button>
            </form>
            <div class="table-responsive my-5">
                <h2>29 April 2023</h2>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            @for ($i = 8; $i <= 23; $i++)
                                <th> {{ $i }}:00 </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>JURTi</td>
                            <td>JURTi</td>
                            <td>Sipil</td>
                            <td>Akuntantis</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
@endsection
