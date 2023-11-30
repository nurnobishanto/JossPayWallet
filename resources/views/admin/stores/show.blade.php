@extends('adminlte::page')

@section('title', __('global.view_store'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_store')}} - {{$store->business_name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.stores.index')}}">{{__('global.stores')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_store')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                        <input id="balance"  class="form-control" value="{{$store->balance}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_name">{{ __('global.business_name')}}</label>
                                        <input id="business_name" name="business_name" class="form-control" value="{{$store->business_name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">{{__('global.select_user')}} <span class="text-danger"> *</span></label>
                                        <input id="user_id" name="business_name" class="form-control" value="{{$store->user->name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_name">{{ __('global.business_name')}}</label>
                                        <input id="business_name" name="business_name" class="form-control" value="{{$store->business_name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_type">{{ __('global.business_type')}}</label>
                                        <input id="business_type" name="business_type" class="form-control" value="{{$store->business_type}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_number">{{ __('global.mobile_number')}}</label>
                                        <input id="mobile_number" name="mobile_number" value="{{$store->mobile_number}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_email">{{ __('global.business_email')}}</label>
                                        <input id="business_email" name="business_email" value="{{$store->business_email}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="domain_name">{{ __('global.domain_name')}}</label>
                                        <input id="domain_name" name="domain_name" value="{{$store->domain_name}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website_url">{{ __('global.website_url')}}</label>
                                        <input id="website_url" name="website_url" value="{{$store->website_url}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="server_ip">{{ __('global.server_ip')}}</label>
                                        <input id="server_ip" name="server_ip" value="{{$store->server_ip}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="charge">{{ __('global.charge')}}</label>
                                        <input id="charge" name="charge" value="{{$store->charge}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="add1">{{ __('global.add1')}}<span class="text-danger"> *</span></label>
                                        <input disabled id="add1" name="add1" value="{{$store->add1}}" type="text" class="form-control" placeholder="{{ __('global.enter_add1')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="add2">{{ __('global.add2')}}<span class="text-danger"> *</span></label>
                                        <input disabled id="add2" name="add2" value="{{$store->add2}}" type="text" class="form-control" placeholder="{{ __('global.enter_add2')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">{{ __('global.city')}}<span class="text-danger"> *</span></label>
                                        <input  disabled id="city" name="city" value="{{$store->city}}" type="text" class="form-control" placeholder="{{ __('global.enter_city')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">{{ __('global.state')}}<span class="text-danger"> *</span></label>
                                        <input disabled id="state" name="state" value="{{$store->state}}" type="text" class="form-control" placeholder="{{ __('global.enter_state')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">{{ __('global.country')}}<span class="text-danger"> *</span></label>
                                        <input disabled id="country" name="country"  type="text" value="{{$store->country}}" class="form-control" placeholder="{{ __('global.enter_country')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{__('global.select_status')}}</label>
                                        <select name="status" class="form-control" id="status" disabled>
                                            <option value="active" @if($store->status == 'active') selected @endif>{{__('global.active')}}</option>
                                            <option value="deactivated" @if($store->status == 'deactivated') selected @endif>{{__('global.deactivated')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img src="{{asset('uploads/'.$store->business_logo)}}" alt="Selected Image" id="selected-image" style="max-height: 150px">
                                </div>

                            </div>



                        <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.stores.index')}}" class="btn btn-success" >Go Back</a>
                            @can('store_update')
                                <a href="{{route('admin.stores.edit',['store'=>$store->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('store_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
@section('plugins.Sweetalert2', true)
@section('css')

@stop

@section('js')
    <script>
        function isDelete(button) {
            event.preventDefault();
            var row = $(button).closest("tr");
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('global.deleteConfirmTitle')),
                text: @json(__('global.deleteConfirmText')),
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: @json(__('global.deleteConfirmButtonText')),
                cancelButtonText: @json(__('global.deleteCancelButton')),
            }).then((result) => {
                console.log(result)
                if (result.value) {
                    // Trigger the form submission
                    form.submit();
                }
            });
        }
        function checkSinglePermission(idName, className,inGroupCount,total,groupCount) {
            if($('.'+className+' input:checked').length === inGroupCount){
                $('#'+idName).prop('checked',true);
            }else {
                $('#'+idName).prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        function checkPermissionByGroup(idName, className,total,groupCount) {
            if($('#'+idName).is(':checked')){
                $('.'+className+' input').prop('checked',true);
            }else {
                $('.'+className+' input').prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        $('#select_all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@stop
