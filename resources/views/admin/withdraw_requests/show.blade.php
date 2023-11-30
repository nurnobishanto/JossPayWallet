@extends('adminlte::page')

@section('title', __('global.view_withdraw_request'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_withdraw_request')}} - {{$withdraw_request->store->business_name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.withdraw-requests.index')}}">{{__('global.withdraw_requests')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_withdraw_request')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr><th width="30%">Name</th><th>Value</th></tr>
                            </thead>
                            <tbody>
                            <tr><th>User</th><td>{{$withdraw_request->user->name}}</td></tr>
                            <tr><th>Store</th><td>{{$withdraw_request->store->business_name }} - {{$withdraw_request->store->store_id }}</td></tr>
                            <tr><th>Account</th><td>{{$withdraw_request->withdraw_account->bank_name}} - {{$withdraw_request->withdraw_account->account_name}}</td></tr>
                            <tr><th>Amount</th><td>{{$withdraw_request->amount}}</td></tr>
                            <tr><th>Tran ID</th><td>{{$withdraw_request->tran_id}}</td></tr>
                            <tr><th>Status</th><td>{{$withdraw_request->status}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                        <form action="{{ route('admin.withdraw-requests.destroy', $withdraw_request->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.withdraw-requests.index')}}" class="btn btn-success" >Go Back</a>
                            @can('withdraw_request_update')
                                <a href="{{route('admin.withdraw-requests.edit',['withdraw_request'=>$withdraw_request->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('withdraw_request_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                            @if($withdraw_request->status != 'success')
                                <a href="{{route('admin.withdraw-requests.success',['withdraw_request'=>$withdraw_request->id])}}" class="btn btn-primary">Approve</a>
                                <a href="{{route('admin.withdraw-requests.reject',['withdraw_request'=>$withdraw_request->id])}}" class="btn btn-danger">Reject</a>
                            @endif
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
