@extends('adminlte::page')

@section('title', __('global.withdraw_accounts'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.withdraw_accounts')}} {{__('global.deleted')}}</h1>
            @can('withdraw_account_list')
                <a href="{{route('admin.withdraw-accounts.index')}}" class="btn btn-primary mt-2">{{__('global.go_back')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.withdraw_accounts')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('withdraw_account_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="withdraw_accountsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="8%">{{__('global.sl')}}</th>
                                <th width="15%">{{__('global.user')}}</th>
                                <th width="20%">{{__('global.bank_name')}}</th>
                                <th width="17%">{{__('global.account_name')}}</th>
                                <th width="18%">{{__('global.account_no')}}</th>
                                <th width="20%">{{__('global.account_type')}}</th>
                                <th width="7%">{{__('global.status')}}</th>
                                <th width="15%">{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraw_accounts as $store)
                                <tr>
                                    <td>{{$withdraw_account->id}}</td>
                                    <td>{{$withdraw_account->user->name}}</td>
                                    <td>{{$withdraw_account->bank_name}}</td>
                                    <td>{{$withdraw_account->account_name}}</td>
                                    <td>{{$withdraw_account->account_no}}</td>
                                    <td>{{__('global.'.$withdraw_account->account_type)}}</td>
                                    <td>{{__('global.'.$withdraw_account->status)}}
                                    <td class="text-center">
                                        @can('withdraw_account_delete')
                                        <a href="{{route('admin.withdraw-accounts.restore',['store'=>$store->id])}}"  class="btn btn-success btn-sm px-1 py-0"><i class="fa fa-arrow-left"></i></a>
                                        <a href="{{route('admin.withdraw-accounts.force_delete',['store'=>$store->id])}}"  class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="8%">{{__('global.sl')}}</th>
                                <th width="15%">{{__('global.user')}}</th>
                                <th width="20%">{{__('global.bank_name')}}</th>
                                <th width="17%">{{__('global.account_name')}}</th>
                                <th width="18%">{{__('global.account_no')}}</th>
                                <th width="20%">{{__('global.account_type')}}</th>
                                <th width="7%">{{__('global.status')}}</th>
                                <th width="15%">{{__('global.action')}}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endcan

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
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
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

        $(document).ready(function() {
            $("#withdraw_accountsList").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: true,
                ordering: true,
                info: true,
                paging: true,
                buttons: [
                    {
                        extend: 'copy',
                        text: '{{ __('global.copy') }}',
                    },
                    {
                        extend: 'csv',
                        text: '{{ __('global.export_csv') }}',
                    },
                    {
                        extend: 'excel',
                        text: '{{ __('global.export_excel') }}',
                    },
                    {
                        extend: 'pdf',
                        text: '{{ __('global.export_pdf') }}',
                    },
                    {
                        extend: 'print',
                        text: '{{ __('global.print') }}',
                    },
                    {
                        extend: 'colvis',
                        text: '{{ __('global.colvis') }}',
                    }
                ],
                pagingType: 'full_numbers',
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    paginate: {
                        first: "{{ __('global.first') }}",
                        previous: "{{ __('global.previous') }}",
                        next: "{{ __('global.next') }}",
                        last: "{{ __('global.last') }}",
                    }
                }
            });

        });

    </script>
@stop
