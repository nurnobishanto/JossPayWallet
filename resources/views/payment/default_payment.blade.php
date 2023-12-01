@extends('layouts.master')
@section('meta')
    <title>Default Payment</title>
@endsection
@section('content')
    <div class="container">
        <form action="{{route('payment_request')}}" method="post">
            @csrf
            <div class="card myBox">
                <div class="card-header">
                    <h5 class="card-title">Make your payment</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if($store->business_logo)
                            <p class="text-center">
                                <img src="{{asset('uploads/'.$store->business_logo)}}" class="img-thumbnail" style="max-height: 150px">
                            </p>
                            @endif

                            <p class="mb-0"><strong>Store Name :</strong> {{$store->business_name}}</p>
                            <p class="mb-0"><strong>Store ID :</strong>  {{$store->store_id}}</p>
                            <input class="d-none" name="store_id" value="{{$store->store_id}}" required>
                            <input class="d-none" name="api_key" value="{{$store->api_key}}" required>
                            <input class="d-none" name="tran_id" value="{{$tran_id}}" required>
                            <input class="d-none" name="success_url" value="{{route('payment_status')}}" required>
                            <input class="d-none" name="fail_url" value="{{route('payment_status')}}" required>
                            <input class="d-none" name="cancel_url" value="{{route('payment_status')}}" required>
                            <input class="d-none" name="currency" value="BDT" required>
                            <input class="d-none" name="cus_email" value="{{$store->business_email}}" required>
                            <input class="d-none" name="cus_add1" value="{{$store->add1}}" required>
                            <input class="d-none" name="cus_add2" value="{{$store->add2}}" required>
                            <input class="d-none" name="cus_city" value="{{$store->city}}" required>
                            <input class="d-none" name="cus_state" value="{{$store->state}}" required>
                            <input class="d-none" name="cus_country" value="{{$store->country}}" required>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cus_name">Full name <span class="text-danger text-bold"> *</span></label>
                                    <input class="form-control" id="cus_name" name="cus_name" type="text" min="0" placeholder="Enter your full name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cus_phone">Your phone number <span class="text-danger text-bold"> *</span></label>
                                    <input class="form-control" id="cus_phone" name="cus_phone" type="text" min="0" placeholder="Enter your phone number" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="desc">Payment For <span class="text-danger text-bold"> *</span></label>
                                    <input class="form-control" id="desc" name="desc" type="text" min="0" placeholder="Enter reason for payment" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount">Payment Amount <span class="text-danger text-bold"> *</span></label>
                                    <input class="form-control" id="amount" name="amount" type="number" min="0" placeholder="Enter amount" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input class="form-control btn btn-danger" type="submit" value="Payment">
                </div>
            </div>
        </form>

    </div>
@endsection


