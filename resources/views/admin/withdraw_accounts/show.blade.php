@extends('adminlte::page')

@section('title', __('global.view_withdraw_account'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_withdraw_account')}} - {{$withdraw_account->business_name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.withdraw-accounts.index')}}">{{__('global.withdraw_accounts')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_withdraw_account')}}</li>
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
                                        <label for="user_id">{{ __('global.user')}}</label>
                                        <input id="user_id" disabled class="form-control" value="{{$withdraw_account->user->name}}" placeholder="{{ __('global.withdraw_account_id')}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_name">{{ __('global.bank_name')}}</label>
                                        <input id="bank_name" name="bank_name" value="{{$withdraw_account->bank_name}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_name">{{ __('global.account_name')}}</label>
                                        <input id="account_name" name="account_name" value="{{$withdraw_account->account_name}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_no">{{ __('global.account_no')}}</label>
                                        <input id="account_no" name="account_no" value="{{$withdraw_account->account_no}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_type">{{ __('global.account_type')}}</label>
                                        <input id="account_type" name="account_type" value="{{$withdraw_account->account_type}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branch_name">{{ __('global.branch_name')}}</label>
                                        <input id="branch_name" name="branch_name" value="{{$withdraw_account->branch_name}}" class="form-control" disabled>
                                    </div>
                                </div> <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="routing_no">{{ __('global.routing_no')}}</label>
                                        <input id="routing_no" name="routing_no" value="{{$withdraw_account->routing_no}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{__('global.select_status')}}</label>
                                        <select name="status" class="form-control" id="status" disabled>
                                            <option value="pending" @if($withdraw_account->status == 'pending') selected @endif>{{__('global.pending')}}</option>
                                            <option value="active" @if($withdraw_account->status == 'active') selected @endif>{{__('global.active')}}</option>
                                            <option value="rejected" @if($withdraw_account->status == 'rejected') selected @endif>{{__('global.rejected')}}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>



                        <form action="{{ route('admin.withdraw-accounts.destroy', $withdraw_account->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.withdraw-accounts.index')}}" class="btn btn-success" >Go Back</a>
                            @can('withdraw_account_update')
                                <a href="{{route('admin.withdraw-accounts.edit',['withdraw_account'=>$withdraw_account->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('withdraw_account_delete')
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
