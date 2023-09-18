@extends('adminlte::page')

@section('title', __('global.update_store'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_store')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.stores.index')}}">{{ __('global.stores')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_store')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.stores.update',['store'=>$store->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="store_id">{{ __('global.store_id')}}</label>
                                    <input id="store_id"  class="form-control" value="{{$store->store_id}}" placeholder="{{ __('global.store_id')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="api_key">{{ __('global.api_key')}}</label>
                                    <input id="api_key"  class="form-control" value="{{$store->api_key}}" placeholder="{{ __('global.api_key')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="balance">{{ __('global.balance')}}</label>
                                    <input id="balance"  class="form-control" value="{{$store->balance}}" placeholder="{{ __('global.balance')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_name">{{ __('global.business_name')}}</label>
                                    <input id="business_name" name="business_name" class="form-control" value="{{$store->business_name}}" placeholder="{{ __('global.enter_business_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">{{__('global.select_user')}} <span class="text-danger"> *</span></label>
                                    <select name="user_id" class="select2 form-control" id="user_id">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" @if($user->id == $store->user_id) selected @endif>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_name">{{ __('global.business_name')}}</label>
                                    <input id="business_name" name="business_name" class="form-control" value="{{$store->business_name}}" placeholder="{{ __('global.enter_business_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_logo">{{__('global.select_business_logo')}}</label>
                                    <input name="business_logo" type="file" class="form-control"  id="photo" accept="image/*">
                                    <input name="business_logo_old"  class="form-control d-none" value="{{$store->business_logo}}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_type">{{ __('global.business_type')}}</label>
                                    <input id="business_type" name="business_type" class="form-control" value="{{$store->business_type}}" placeholder="{{ __('global.enter_business_type')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile_number">{{ __('global.mobile_number')}}</label>
                                    <input id="mobile_number" name="mobile_number" value="{{$store->mobile_number}}" class="form-control" placeholder="{{ __('global.enter_mobile_number')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_email">{{ __('global.business_email')}}</label>
                                    <input id="business_email" name="business_email" value="{{$store->business_email}}" class="form-control" placeholder="{{ __('global.enter_business_email')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="domain_name">{{ __('global.domain_name')}}</label>
                                    <input id="domain_name" name="domain_name" value="{{$store->domain_name}}" class="form-control" placeholder="{{ __('global.enter_domain_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website_url">{{ __('global.website_url')}}</label>
                                    <input id="website_url" name="website_url" value="{{$store->website_url}}" class="form-control" placeholder="{{ __('global.enter_website_url')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="server_ip">{{ __('global.server_ip')}}</label>
                                    <input id="server_ip" name="server_ip" value="{{$store->server_ip}}" class="form-control" placeholder="{{ __('global.enter_server_ip')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="charge">{{ __('global.charge')}}</label>
                                    <input id="charge" name="charge" value="{{$store->charge}}" class="form-control" placeholder="{{ __('global.enter_charge')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($store->status == 'active') selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate" @if($store->status == 'deactivate') selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="{{asset('uploads/'.$store->business_logo)}}" alt="Selected Image" id="selected-image" style="max-height: 150px">
                            </div>

                        </div>

                        @can('store_update')
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
