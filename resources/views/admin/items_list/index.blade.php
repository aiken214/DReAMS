@extends('layouts.admin')

@section('content')
@can('items_list_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.items_list.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.items_list.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'ItemsList', 'route' => 'admin.items_list.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.items_list.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="items_listTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.items_list.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.items_list.fields.item_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.items_list.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.items_list.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.items_list.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.items_list.fields.category') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {
        // Define buttons for DataTable, including the delete functionality
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        @can('items_list_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.items_list.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: { 'x-csrf-token': _token },
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    })
                    .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#items_listTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.items_list.index') }}', // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'item_code', name: 'item_code' },
                { data: 'description', name: 'description', render: function ( data, type, row ) {
                    return '<span style="white-space:normal">' + data + "</span>";
                }},  
                { data: 'unit', name: 'unit' },
                { data: 'price', name: 'price', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'category', name: 'category' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('items_list_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.items_list.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('items_list_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('admin/items_list') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('items_list_delete')
                                <form action="{{ route('admin.items_list.destroy', '') }}/${data}" method="POST" 
                                    onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                    data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan`;
                    },
                    orderable: false // Disable sorting on action buttons column
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-head-left', targets: [7], orderable: false }, // Align header left for column 7
                { className: 'dt-body-right', targets: [5] }, // Align body cells right for column 5
                { className: 'dt-left', targets: [7] }, 
                { targets: 0, orderable: false, className: 'select-checkbox' } // Checkbox for row selection
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            // Add the createdRow function to modify the row
            createdRow: function (row, data, dataIndex) {
            // Add data-entry-id attribute
            $(row).attr('data-entry-id', data.id);
            }
        });

        // Ensure table columns adjust on tab switching
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });
</script>


@endsection