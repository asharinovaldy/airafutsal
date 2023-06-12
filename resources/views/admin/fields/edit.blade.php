@extends('layouts.admin.layouts')
@section('content')
    <div class="container">
        <a href="{{ route('admin.fields') }}" class="btn btn-link">Kembali ke Data Lapangan</a>
        <div class="row">
            <div class="col-8">
                <h3>Edit Data Lapangan</h3>
                <form action="{{ route('admin.update.fields', $field->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="field_name" class="form-label">Lapangan</label>
                        <input type="text" class="form-control" name="field_name" id="field_name" value="{{ $field->field_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga per Jam</label>
                        <input type="number" class="form-control" name="price" id="price" value="{{ $field->price }}" required>
                    </div>
                    <button type="reset" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
