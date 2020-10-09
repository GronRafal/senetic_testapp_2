@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' Customers')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-people"></i> Customers
            <a href="{{ route('voyager.customer.store') }}" class="btn btn-success">
                <i class="voyager-plus"></i> {{ __('voyager::generic.add_new') }}
            </a>
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataTypeContent as $data)
                                <tr>
                                    @foreach($data as $row)
                                        <td>
                                            {{ $row }}
                                        </td>
                                    @endforeach
                                    <td class="no-sort no-click bread-actions">
                                        <a href="{{ route('voyager.customer.show', $data->id) }}" class="btn btn-sm btn-warning pull-right desctable" style="display:inline; margin-right:10px;">
                                            <i class="voyager-eye"></i> {{ __('voyager::generic.view') }}
                                        </a>
                                        <div class="btn btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}">
                                            <i class="voyager-trash"></i> {{ __('voyager::generic.delete') }}
                                        </div>
                                        <a href="{{ route('voyager.customer.edit', $data->id) }}" class="btn btn-sm btn-primary pull-right edit">
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
                        <i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} Customer?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_this_confirm') }} Customer">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
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
            $('#delete_form')[0].action = '{{ route('voyager.customer.destroy', ['id' => '__menu']) }}'.replace('__menu', $(this).data('id'));
            $('#delete_modal').modal('show');
        });
    </script>
@stop
