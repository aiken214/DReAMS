@extends('layouts.user')

@section('content')
@can('ris_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary" href="{{ route('supply.rsmi_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.rsmi.title_short') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rsmi_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="rsmi_itemTable">
                <thead>
                    <tr>                        
                        <th>
                            {{ trans('cruds.rsmi_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.ris_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.res_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.stock_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.item') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.issued_quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.unit_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.amount') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table> 
        </div>
        <div class="row" style="margin-top: 20px; margin-left: 5px">
            <p style="margin-bottom:2px;"><b>Recapitulation:</b></p>
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="stockTable">
                <thead>
                    <tr>                        
                        <th>
                            {{ trans('cruds.rsmi_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.stock_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.item') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.unit_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.total_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.rsmi_item.fields.uacs') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_rsmi_id" id="hidden_rsmi_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script type="text/javascript" language="javascript" src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
<script>
    var rsmi_id = $('#hidden_rsmi_id').val();   
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {
        // Define buttons for DataTable, including the delete functionality
        //let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons); //To display buttons like select all, deselect all, excel, pdf, print.

        // Ensure rsmi_id is defined before using it in AJAX
        let rsmi_id = typeof window.rsmi_id !== 'undefined' ? window.rsmi_id : null;

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            pageLength: 15,
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable for rsmi_itemTable
        let rsmiTable = $('#rsmi_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.rsmi_item.index') }}?rsmi_id=' + rsmi_id,
            order: [[1, 'asc']], // Sort by ris_no   
            dom: '<"top"lf>rt<"bottom"ip>',        
            "rowsGroup": [1],        
            columns: [
                { data: 'id', name: 'id' },
                { data: 'ris_no', name: 'ris_no' }, // Now properly sortable
                { data: 'res_code', name: 'res_code' },
                { data: 'stock_no', name: 'stock_no' },
                { data: 'description', name: 'description' },
                { data: 'unit', name: 'unit' },
                { data: 'issued_quantity', name: 'issued_quantity' },
                { data: 'unit_cost', name: 'unit_cost' },
                { data: 'amount', name: 'amount' },
            ],
            columnDefs: [
                { targets: [0], visible: false }, // Hide ID column
                { className: 'dt-body-right', targets: [2, 6, 7, 8] },
            ],
        });

        // Ensure table columns adjust on tab switching
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        // Initialize DataTable for stockTable
        let stockTable = $('#stockTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.recap_rsmi_item.index') }}?rsmi_id=' + rsmi_id, // Your API route
            // buttons: dtButtons, // Include delete buttons
            order: [], // Prevents overriding backend sorting
            dom: 't', // Removes all buttons, search, pagination, and length menu
            columns: [
                { data: 'id', name: 'id' },
                { data: 'stock_no', name: 'stock_no' },
                { data: 'receipt_quantity', name: 'receipt_quantity' },
                { data: 'description', name: 'description' },
                { data: 'unit', name: 'unit' },
                { data: 'unit_price', name: 'unit_price' },
                { data: 'amount', name: 'amount' },
                { data: 'uacs_code', name: 'uacs_code' },
            ],
            columnDefs: [
                { targets: [0], visible: false },
                { className: 'dt-body-right', targets: [2, 5, 6] },
            ],
        });
    });
</script>


@endsection