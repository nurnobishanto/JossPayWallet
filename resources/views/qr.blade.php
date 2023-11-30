@extends('layouts.master')
@section('meta')
    <title>Qr Code</title>
@endsection
@section('content')
    <div class="container">
        <div class="card myBox">
            <div class="card-header">
                <h5 class="card-title">{{$title}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p class="mb-0"><strong>Store Name :</strong> {{$store->business_name}}</p>
                        <p class="mb-0"><strong>Store ID :</strong>  {{$store->store_id}}</p>
                        <hr>
                    </div>
                    <div class="col-12 text-center">

                        @if($qrCodeImage)
                            <img src="data:image/png;base64, {!!  base64_encode($qrCodeImage) !!}"/>
                        @else
                            {!! $qrCode !!}
                        @endif

                    </div>
                    <div class="col-12 text-center mt-2">
                        <a href="{{$link}}" />{{$link}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


