@extends('layouts.admin.layouts')
@section('content')
    <div class="container">
        <div class="my-3">
        <h2 class="mb-5">Data Lapangan</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Data Lapangan
        </button>
            <div class="table-responsive my-3">
                <table class="table table-striped table-bordered" id="fieldsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lapangan</th>
                            <th>Harga per Jam</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Lapangan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.store.fields') }}" method="post">
            @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="field_name" class="form-label">Lapangan</label>
                        <input type="text" class="form-control" name="field_name" id="field_name" placeholder="Lapangan 1" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga per Jam</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="150000" required>
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

        $(document).ready(function(){
            let id = 1
            $('#fieldsTable').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ajax: {
                    url: '{{ url('admin/data/fields') }}',
                    type: 'GET',
                    dataType: 'JSON',
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'field_name', name: 'field_name' },
                    { data: 'price', name: 'price' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            })
        })

    </script>
@endsection
