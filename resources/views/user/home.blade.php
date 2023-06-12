@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> AIRA SPORTS FUTSAL </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('user.my-schedules') }}" class="btn btn-primary">Booking Sekarang!</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
