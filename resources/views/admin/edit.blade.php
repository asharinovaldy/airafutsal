@extends('layouts.admin.layouts')
@section('content')
<div class="container">
    <a href="{{ route('admin.schedules') }}" class="btn btn-link">Kembali ke data jadwal</a>
    <div class="row">
        <div class="col-8">
            <div class="card shadow-sm p-3 mb-5 bg-body-tertiary rounded my-3">
                <div class="card-header">
                  <h2>Data Order Aira Futsal</h2>
                </div>
                <div class="card-body my-3">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td> <p class="fw-bold">ID</p> </td>
                                <td> #{{$order->prefix}} </td>
                            </tr>
                            <tr>
                                <td> <p class="fw-bold">Lapangan</p> </td>
                                <td> Lapangan {{$order->field_id}} </td>
                            </tr>
                            <tr>
                                <td> <p class="fw-bold">Harga Lapangan per Jam</p> </td>
                                <td>  Rp. {{ number_format($price_field->price, 2, ',','.')}} </td>
                            </tr>
                            <tr>
                                <td> <p class="fw-bold">Durasi</p> </td>
                                <td> {{$order->duration}} Jam </td>
                            </tr>
                            <tr>
                                <td><p class="fw-bold">Sewa Sepatu</p></td>
                                <td>
                                        {{ $order->boots_id ? $order->boots?->name : '-' }} <br /> <img src="{{ Storage::url('images/').$order->boots?->image }}" alt="" height="100" srcset="">
                                </td>
                            </tr>
                            <tr>
                                <td><p class="fw-bold">Sewa Bola</p></td>
                                <td> {{ $order->balls_id ? $order->balls?->name : '-' }} <br /> <img src="{{ Storage::url('images/').$order->balls?->image }}" alt="" height="100" srcset="">  </td>
                            </tr>
                            <tr>
                                <td> <p class="fw-bold">Total Harga</p> </td>
                                <td> Rp. {{ number_format($order->total_amount, 2, ',','.')}} </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <h3 class="text-uppercase">Status Pembayaran</h3>
                        <p class="fw-bold fs-3 {{ $order->status == 'Pending' ? 'text-warning' : 'text-success'}}" > {{ $order->status }} </p>
                    </div>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
