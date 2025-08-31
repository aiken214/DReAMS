@extends('layouts.user')

@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">            
        <a class="btn btn-secondary" href="{{ route('user.purchase_request_print', $id) }}">
            {{ trans('global.view') }} {{ trans('cruds.purchase_request.title_singular') }}
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchase_request_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="purchase_request_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.stock_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.unit_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.total_cost') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_purchase_request_id" id="hidden_purchase_request_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var purchase_request_id = $('#hidden_purchase_request_id').val();   
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {
        // Define buttons for DataTable, including the delete functionality
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons) //To display buttons like select all, deselect all, excel, pdf, print. Edit it in the layouts.use

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#purchase_request_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.purchase_request_item_check.index') }}?purchase_request_id='+purchase_request_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'stock_no', name: 'stock_no' },
                { data: 'description', name: 'description', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }},  
                { data: 'unit', name: 'unit' },
                { data: 'quantity', name: 'quantity' },
                { data: 'unit_price', name: 'unit_price', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'total_cost', name: 'total_cost', render: $.fn.dataTable.render.number(',', '.', 2)},
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [5, 6, 7]},
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