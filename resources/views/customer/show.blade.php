@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' Customer')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-people"></i> Customer
        <a href="{{ route('voyager.customer.edit', $customer->id) }}" class="btn btn-sm btn-primary pull-right edit">
            <i class="voyager-edit"></i> {{ __('voyager::generic.edit') }}
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <!-- form start -->
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Id</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">
                        <p>{{ $customer->id }}</p>
                    </div>

                    <hr style="margin:0;">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Name</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">
                        <p>{{ $customer->name }}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Created</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">
                        <p>{{ $customer->created_at }}</p>
                    </div>
                    <hr style="margin:0;">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Updated</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">
                        <p>{{ $customer->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h1 class="page-title">
                            <i class="voyager-location"></i> Addresses
                            <a href="{{ route('voyager.address.store', $customer->id) }}" class="btn btn-sm btn-primary pull-right edit">
                                <i class="voyager-plus"></i> {{ __('voyager::generic.add_new') }}
                            </a>
                        </h1>
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Street</th>
                                <th>City</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($addresses as $address)
                                <tr>
                                    <td>
                                        {{ $address->id }}
                                    </td>
                                    <td>
                                        {{ $address->street }}
                                    </td>
                                    <td>
                                        {{ $address->city }}
                                    </td>
                                    <td>
                                        {{ $address->created_at }}
                                    </td>
                                    <td>
                                        {{ $address->updated_at }}
                                    </td>
                                    <td class="no-sort no-click bread-actions">
                                        <div class="btn btn-sm btn-danger pull-right delete" data-id="{{ $address->id }}">
                                            <i class="voyager-trash"></i> {{ __('voyager::generic.delete') }}
                                        </div>
                                        <a href="{{ route('voyager.address.edit', $address->id) }}" class="btn btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> {{ __('voyager::generic.edit') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} Address?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_this_confirm') }} Address">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "order": [],
                "language": {!! json_encode(__('voyager::datatable'), true) !!},
                "columnDefs": [{"targets": -1, "searchable":  false, "orderable": false}]
                @if(config('dashboard.data_tables.responsive')), responsive: true @endif
            });
        });

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.address.destroy', ['id' => '__menu']) }}'.replace('__menu', $(this).data('id'));
            $('#delete_modal').modal('show');
        });
    </script>
@stop
