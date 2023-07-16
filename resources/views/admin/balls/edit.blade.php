@extends('layouts.admin.layouts')
@section('content')
    <div class="container">
        <a href="{{ route('admin.balls') }}" class="btn btn-link">Kembali ke Data Bola</a>
        <div class="row">
            <div class="col-8">
                <h3>Edit Data Bola</h3>
                <form action="{{ route('admin.balls.update', $balls->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="balls_name" class="form-label">Nama Sepatu</label>
                        <input type="text" class="form-control" name="balls_name" id="balls_name" value="{{ $balls->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="balls_price" class="form-label">Harga Sewa</label>
                        <input type="number" class="form-control" name="balls_price" id="balls_price" value="{{ $balls->price }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="balls_stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" name="balls_stock" id="balls_stock" value="{{ $balls->stock }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Masukkan Gambar</label>
                        <input type="file" accept="image/*" onchange="previewImageOnEdit()" class="form-control" name="image" id="image">
                        @if ($errors->has('image'))
                            <span class="text-danger text-left"> {{ $errors->first('image') }} </span>
                        @endif
                    </div>
                        <div class="form-group text-center my-2">
                            <img src="{{ Storage::url('images/').$balls->image }}" id="imgpreview" alt="" height="200" />
                        </div>
                    <button type="reset" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function previewImageOnEdit() {
            imgpreview.src=URL.createObjectURL(event.target.files[0])
        }
    </script>
@endsection
