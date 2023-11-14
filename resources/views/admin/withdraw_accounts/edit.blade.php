@extends('adminlte::page')

@section('title', __('global.update_withdraw_account'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_withdraw_account')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.withdraw-accounts.index')}}">{{ __('global.withdraw_accounts')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_withdraw_account')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.withdraw-accounts.update',['withdraw_account'=>$withdraw_account->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @method('PUT')
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
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" @if($user->id == $withdraw_account->user_id) selected @endif>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bank_name">{{ __('global.bank_name')}}</label>
                                    <input id="bank_name" name="bank_name" class="form-control" value="{{$withdraw_account->bank_name}}" placeholder="{{ __('global.enter_bank_name')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_name">{{ __('global.account_name')}}</label>
                                    <input id="account_name" name="account_name" class="form-control" value="{{$withdraw_account->account_name}}" placeholder="{{ __('global.enter_account_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_no">{{ __('global.account_no')}}</label>
                                    <input id="account_no" name="account_no" value="{{$withdraw_account->account_no}}" class="form-control" placeholder="{{ __('global.enter_account_no')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_type">{{ __('global.account_type')}}</label>
                                    <select id="account_type" name="account_type" class="form-control">
                                        <option value="bank" @if($withdraw_account->account_typ == 'bank') selected @endif>Bank</option>
                                        <option value="mobile_bank" @if($withdraw_account->account_typ == 'mobile_bank') selected @endif>Mobile Bank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_name">{{ __('global.branch_name')}}</label>
                                    <input id="branch_name" name="branch_name" value="{{$withdraw_account->branch_name}}" class="form-control" placeholder="{{ __('global.enter_branch_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="routing_no">{{ __('global.routing_no')}}</label>
                                    <input id="routing_no" name="routing_no" value="{{$withdraw_account->routing_no}}" class="form-control" placeholder="{{ __('global.enter_routing_no')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="pending" @if($withdraw_account->status == 'pending') selected @endif>{{__('global.pending')}}</option>
                                        <option value="active" @if($withdraw_account->status == 'active') selected @endif>{{__('global.active')}}</option>
                                        <option value="rejected" @if($withdraw_account->status == 'rejected') selected @endif>{{__('global.rejected')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @can('withdraw_account_update')
                            <button class="btn btn-success" type="submit">{{ __('global.update')}}</button>
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
    });
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
