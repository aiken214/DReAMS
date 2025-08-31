@extends('layouts.user')

@section('content')

<div class="card">
    <div class="card-header">
        {{ "Property" }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="rrspTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.common.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.stock_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.receipt_quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.balance_quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.unit_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.remarks') }}
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

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 3, 'asc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#rrspTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.property.index') }}', // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'stock_no', name: 'stock_no' },
                { data: 'description', name: 'description' },
                { data: 'unit', name: 'unit' },
                { data: 'receipt_quantity', name: 'receipt_quantity' },
                { data: 'balance_quantity', name: 'balance_quantity' },
                { data: 'unit_price', name: 'unit_price', render: $.fn.dataTable.render.number(',', '.', 2) },
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2) },
                { data: 'type', name: 'type' },
                { data: 'remarks', name: 'remarks' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('property_card_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.property.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('property_card_access')
                                <a class="btn btn-xs btn-success" href="{{ route('supply.property_card.index2', '') }}/${data}">
                                    {{ trans('global.item') }}
                                </a>
                            @endcan`;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [5, 6, 7, 8]},
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

    });
</script>


@endsection