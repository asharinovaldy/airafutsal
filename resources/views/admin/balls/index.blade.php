@extends('layouts.admin.layouts')
@section('content')
    <div class="container">
        <div class="my-3">
        <h2 class="mb-5">Data Bola</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Data Bola
        </button>
            <div class="table-responsive my-3">
                <table class="table table-striped table-bordered" id="ballsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Nama</th>
                            <th>Harga Sewa</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balls as $ball)
                            <tr>
                                <td> {{ $ball->id }} </td>
                                <td> <img src="{{ Storage::url('images/').$ball->image }}" alt="" height="150" srcset=""> </td>
                                <td> {{ $ball->name }} </td>
                                <td> {{ $ball->price }} </td>
                                <td> {{ $ball->stock }} </td>
                                <td>
                                    <form action="{{ route('admin.balls.destroy', $ball->id) }}" onsubmit="return confirm('Apakah anda yakin ingin menghapus?');" method="POST">
                                        <a href="{{ route('admin.balls.edit',$ball->id) }}" class="btn btn-warning btn-sm"><i style="font-size: 14px" class="text-white pe-7s-note"></i>Edit</a>
                                        @csrf
                                        @method('DELETE')
                                       <button type="submit" class="btn btn-danger btn-sm"><i style="font-size: 14px" class="pe-7s-trash"></i>Hapus</button>
                                    </form>
                               </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Sepatu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.balls.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="balls_name" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="balls_name" id="balls_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="balls_price" class="form-label">Harga Sewa</label>
                        <input type="number" class="form-control" name="balls_price" id="balls_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="balls_stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" name="balls_stock" id="balls_stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Masukkan Gambar</label>
                        <input type="file" accept="image/*" onchange="previewImageOnAdd()" class="form-control" name="image" id="image" required>
                        @if ($errors->has('image'))
                            <span class="text-danger text-left"> {{ $errors->first('image') }} </span>
                        @endif
                    </div>
                    <div class="form-group text-center my-2">
                        <img id="imgpreview" class="img-thumbnail" alt=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">

    let table = new DataTable('#ballsTable');
        // $(document).ready(function(){
        //     let id = 1
        //     $('#fieldsTable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         paging: true,
        //         ajax: {
        //             url: '{{ url('admin/data/fields') }}',
        //             type: 'GET',
        //             dataType: 'JSON',
        //         },
        //         columns: [
        //             { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        //             { data: 'field_name', name: 'field_name' },
        //             { data: 'price', name: 'price' },
        //             { data: 'action', name: 'action', orderable: false, searchable: false}
        //         ]
        //     })
        // })

        function previewImageOnAdd() {
            imgpreview.src=URL.createObjectURL(event.target.files[0])
        }

    </script>

@endsection
