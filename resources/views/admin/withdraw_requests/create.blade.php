@extends('adminlte::page')

@section('title', __('global.create_withdraw_request'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_withdraw_request')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.withdraw-requests.index')}}">{{ __('global.withdraw_requests')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_withdraw_request')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.withdraw-requests.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @csrf
                        @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">{{__('global.select_user')}} <span class="text-danger"> *</span></label>
                                    <select name="user_id" class="select2 form-control" id="user_id">
                                        <option value="">{{__('global.select_user')}}</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="store_id">{{__('global.select_store')}} <span class="text-danger"> *</span></label>
                                    <select name="store_id" class="select2 form-control" id="store_id">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="withdraw_account_id">{{__('global.select_withdraw_account')}} <span class="text-danger"> *</span></label>
                                    <select name="withdraw_account_id" class="select2 form-control" id="withdraw_account_id">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tran_id">{{__('global.tran_id')}} <span class="text-danger"> *</span></label>
                                    <input name="tran_id" id="tran_id" value="{{uniqid()}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">{{__('global.amount')}} <span class="text-danger"> *</span></label>
                                    <input name="amount" id="amount" value="" class="form-control">
                                </div>
                            </div>
                        </div>

                        @can('withdraw_request_create')
                            <button class="btn btn-success" type="submit">{{ __('global.create')}}</button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <strong>{{__('global.developed_by')}} <a href="https://soft-itbd.com">{{__('global.soft_itbd')}}</a>.</strong>
    {{__('global.all_rights_reserved')}}.
    <div class="float-right d-none d-sm-inline-block">
        <b>{{__('global.version')}}</b> {{env('DEV_VERSION')}}
    </div>
@stop
@section('plugins.toastr',true)
@section('plugins.Select2',true)
@section('css')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: black;
    }
</style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme:'classic'
            });
            $('#user_id').change(function () {
                updateStores($(this).val());
                updateWithdrawAccounts($(this).val());
            });
            $('#store_id').change(function () {
                updateAmount($(this).val());
            });

        });
        function updateStores(user_id) {
            $.ajax({
                url: '/ajax/get-stores/' + user_id,
                type: 'GET',
                success: function (data) {
                    var storeSelect = $('#store_id');
                    storeSelect.empty();

                    $.each(data, function (index, store) {
                        storeSelect.append('<option value="' + store.id + '">' + store.business_name + '</option>');
                    });

                    // Trigger change event to update withdraw accounts
                    storeSelect.change();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        function updateWithdrawAccounts(user_id) {
            $.ajax({
                url: '/ajax/get-withdraw-accounts/' + user_id,
                type: 'GET',
                success: function (data) {
                    var withdrawAccountSelect = $('#withdraw_account_id');
                    withdrawAccountSelect.empty();
                    $.each(data, function (index, account) {
                        withdrawAccountSelect.append('<option value="' + account.id + '">' + account.bank_name +' '+ account.account_name +'</option>');
                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        function updateAmount(store_id) {
            $.ajax({
                url: '/ajax/get-store-balance/' + store_id,
                type: 'GET',
                success: function (data) {
                    // Assuming data contains the balance field
                    var storeBalance = data.balance;
                    var minAmount = 0; // Replace with your actual min amount
                    var maxAmount = storeBalance; // Set maximum as the store balance
                    $('#amount').val(storeBalance);
                    $('#amount').attr('min', minAmount);
                    $('#amount').attr('max', maxAmount);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function () {
            const imageForm = document.getElementById('admin-form');
            const selectedImage = document.getElementById('selected-image');

            imageForm.addEventListener('change', function () {
                const fileInput = this.querySelector('input[type="file"]');
                const file = fileInput.files[0];

                if (file) {
                    const imageUrl = URL.createObjectURL(file);
                    selectedImage.src = imageUrl;
                    selectedImage.style.display = 'block';
                } else {
                    selectedImage.src = '';
                    selectedImage.style.display = 'none';
                }
            });
        });
    </script>
@stop
