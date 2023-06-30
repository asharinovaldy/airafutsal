@extends('layouts.admin.layouts')
@section('content')
    <div class="container">
        <div class="my-3">
        <h2 class="mb-5">Data Sepatu</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Data Sepatu
        </button>
            <div class="table-responsive my-3">
                <table class="table table-striped table-bordered" id="bootsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Nama</th>
                            <th>Ukuran</th>
                            <th>Harga Sewa</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($boots as $boot)
                            <tr>
                                <td> {{ $boot->id }} </td>
                                <td> <img src="{{ Storage::url('images/').$boot->image }}" alt="" height="150" srcset=""> </td>
                                <td> {{ $boot->name }} </td>
                                <td> {{ $boot->size }} </td>
                                <td> {{ $boot->price }} </td>
                                <td> {{ $boot->stock }} </td>
                                <td>
                                    <form action="{{ route('admin.boots.destroy', $boot->id) }}" onsubmit="return confirm('Apakah anda yakin ingin menghapus?');" method="POST">
                                        <a href="{{ route('admin.boots.edit',$boot->id) }}" class="btn btn-warning btn-sm"><i style="font-size: 14px" class="text-white pe-7s-note"></i>Edit</a>
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
            <form action="{{ route('admin.boots.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="boots_name" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="boots_name" id="boots_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="boots_size" class="form-label">Ukuran</label>
                        <input type="number" class="form-control" name="boots_size" id="boots_size" required>
                    </div>
                    <div class="mb-3">
                        <label for="boots_price" class="form-label">Harga Sewa</label>
                        <input type="number" class="form-control" name="boots_price" id="boots_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="boots_stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" name="boots_stock" id="boots_stock" required>
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

    let table = new DataTable('#bootsTable');
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
