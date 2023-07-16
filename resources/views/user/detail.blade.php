@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('user.my-schedules') }}" class="btn btn-link">Kembali ke jadwal saya</a>
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
                                    <td>  Rp. {{ number_format($field->price, 2, ',','.')}} </td>
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
                        @if ($order->status === 'Done')
                            <p>Terimakasih, pembayaran telah sukses ditransfer!</p>
                        @elseif ($order->status === 'Cash')
                            <p>Pembayaran cash, pembayaran dapat dilakukan di lokasi. Terimakasih.</p>
                        @else
                            <button class="btn btn-primary" id="pay-button">Bayar Sekarang</button>
                        @endif
                    </div>
                  </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                }
            });
        });
    </script>
@endsection
