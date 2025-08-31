@extends('layouts.user')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchase_order.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="purchase_orderTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.po_no') }}
                        </th>                        
                        <th>
                            {{ trans('cruds.purchase_order.fields.reference') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.purpose') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.supplier') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.mode') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.delivery') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.term') }}
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
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#purchase_orderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.purchase_order.index') }}', // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'po_no', name: 'po_no' },
                { data: 'pr_no', name: 'pr_no' },
                { data: 'purpose', name: 'purpose' },
                { data: 'supplier', name: 'supplier' },
                { data: 'mode', name: 'mode' },
                { data: 'delivery', name: 'delivery' },
                { data: 'term', name: 'term' },                
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('purchase_order_check_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.purchase_order_check.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('purchase_order_item_check_access')
                                <a class="btn btn-xs btn-success" href="{{ route('supply.purchase_order_item_check.index2', '') }}/${data}">
                                    {{ trans('global.item') }}
                                </a>
                            @endcan`;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
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