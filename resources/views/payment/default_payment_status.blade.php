@extends('layouts.master')
@section('meta')
    <title>{{$title}}</title>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="card @if($status == 'pending') text-bg-warning @elseif($status == 'success') text-bg-success @else text-bg-danger @endif">
            <div class="card-header ">
                <h5 class="card-title">{{$title}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 ">
                        <h2 class="text-center"><strong>Amount: {{$amount}} {{$currency}}</strong></h2>
                        <h3 class="text-center">Status: {{$pay_status}}</h3>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item text-center"><img src="{{asset('uploads/'.$store->business_logo)}}" class="img-thumbnail" style="max-height: 90px"></li>
                            <li class="list-group-item"><strong>Store Name: </strong>{{$store->business_name}}</li>
                            <li class="list-group-item"><strong>Store ID: </strong>{{$store->store_id}}</li>
                            <li class="list-group-item"><strong>Store Person: </strong> {{$store->user->name}}</li>
                            <li class="list-group-item"><strong>Store Phone: </strong> {{$store->mobile_number}}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Reason: </strong>{{$desc}}</li>
                            <li class="list-group-item"><strong>Customer Name: </strong>{{$cus_name}}</li>
                            <li class="list-group-item"><strong>Customer Phone: </strong>{{$cus_phone}}</li>
                            <li class="list-group-item"><strong>Transaction ID: </strong>{{$tran_id}}</li>
                            <li class="list-group-item"><strong>Bank Txn ID: </strong>{{$bank_txn}}</li>
                            <li class="list-group-item"><strong>Time: </strong>{{date('d-m-y h:i a',strtotime($transaction->updated_at))}}</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


