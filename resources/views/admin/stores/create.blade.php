@extends('adminlte::page')

@section('title', __('global.create_store'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_store')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.stores.index')}}">{{ __('global.stores')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_store')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.stores.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <select name="user_id" class="select2 form-control" id="store_id">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_name">{{ __('global.business_name')}} <span class="text-danger"> *</span></label>
                                    <input id="business_name" value="{{old('business_name')}}" name="business_name" class="form-control" placeholder="{{ __('global.enter_business_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_logo">{{__('global.select_business_logo')}}</label>
                                    <input name="business_logo" type="file" class="form-control" id="photo" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_type">{{ __('global.business_type')}}<span class="text-danger"> *</span></label>
                                    <input id="business_type" value="{{old('business_type')}}" name="business_type" class="form-control" placeholder="{{ __('global.enter_business_type')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile_number">{{ __('global.mobile_number')}}<span class="text-danger"> *</span></label>
                                    <input id="mobile_number" value="{{old('mobile_number')}}" name="mobile_number"  class="form-control" placeholder="{{ __('global.enter_mobile_number')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="business_email">{{ __('global.business_email')}}<span class="text-danger"> *</span></label>
                                    <input id="business_email" name="business_email" value="{{old('business_email')}}" class="form-control" placeholder="{{ __('global.enter_business_email')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="domain_name">{{ __('global.domain_name')}}</label>
                                    <input id="domain_name" name="domain_name" value="{{old('domain_name')}}" class="form-control" placeholder="{{ __('global.enter_domain_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website_url">{{ __('global.website_url')}}</label>
                                    <input id="website_url" name="website_url" value="{{old('website_url')}}" class="form-control" placeholder="{{ __('global.enter_website_url')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="server_ip">{{ __('global.server_ip')}}</label>
                                    <input id="server_ip" name="server_ip" value="{{old('server_ip')}}" class="form-control" placeholder="{{ __('global.enter_server_ip')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="charge">{{ __('global.charge')}}<span class="text-danger"> *</span></label>
                                    <input id="charge" name="charge" value="0.5"  type="number" class="form-control" placeholder="{{ __('global.enter_charge')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add1">{{ __('global.add1')}}<span class="text-danger"> *</span></label>
                                    <input id="add1" name="add1" value="{{old('add1')}}" type="text" class="form-control" placeholder="{{ __('global.enter_add1')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add2">{{ __('global.add2')}}<span class="text-danger"> *</span></label>
                                    <input id="add2" name="add2" value="{{old('add2')}}" type="text" class="form-control" placeholder="{{ __('global.enter_add2')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">{{ __('global.city')}}<span class="text-danger"> *</span></label>
                                    <input id="city" name="city" value="{{old('city')}}" type="text" class="form-control" placeholder="{{ __('global.enter_city')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state">{{ __('global.state')}}<span class="text-danger"> *</span></label>
                                    <input id="state" name="state" value="{{old('state')}}" type="text" class="form-control" placeholder="{{ __('global.enter_state')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">{{ __('global.country')}}<span class="text-danger"> *</span></label>
                                    <input id="country" name="country"  type="text" value="Bangladesh" class="form-control" placeholder="{{ __('global.enter_country')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if(old('status') == 'active') selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivated" @if(old('status') == 'deactivated') selected @endif>{{__('global.deactivated')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="" alt="Selected Image" id="selected-image" style="display: none;max-height: 150px">
                            </div>

                        </div>

                        @can('store_create')
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
