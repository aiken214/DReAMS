@extends('layouts.user')

@section('content')
@can('iar_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('supply.iar_item.create2', $id) }}">
                {{ trans('global.add') }} {{ trans('cruds.iar_item.title_short') }}
            </a> 
            <a class="btn btn-primary" href="{{ route('supply.iar_item.create_from_petty_cash', $id) }}">
                {{ trans('global.add') }} {{ trans('cruds.iar_item.title_short') }} {{ 'from Petty Cash'}}
            </a> 
            <a class="btn btn-secondary" href="{{ route('supply.iar_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.iar.title_short') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.iar_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="iar_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.iar_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar_item.fields.stock_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar_item.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar_item.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar_item.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar_item.fields.status') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_iar_id" id="hidden_iar_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var iar_id = $('#hidden_iar_id').val();   
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {
        // Define buttons for DataTable, including the delete functionality
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons) //To display buttons like select all, deselect all, excel, pdf, print. Edit it in the layouts.user

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#iar_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.iar_item.index') }}?iar_id='+iar_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'stock_no', name: 'stock_no' },
                { data: 'description', name: 'description'},  
                { data: 'unit', name: 'unit' },
                { data: 'quantity', name: 'quantity' },
                { data: 'category', name: 'category' },
                { data: 'status', name: 'status' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('iar_item_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.iar_item.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('iar_item_edit')
                                ${(row.issued_quantity === 0) ? `
                                    <a class="btn btn-xs btn-info" href="{{ url('supply/iar_item') }}/${data}/edit">
                                        {{ trans('global.edit') }}
                                    </a>
                                ` : ''}
                            @endcan
                            @can('iar_item_delete')
                                <form action="{{ route('supply.iar_item.destroy', '') }}/${data}" method="POST" 
                                    onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                    data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan`;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [5]},
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