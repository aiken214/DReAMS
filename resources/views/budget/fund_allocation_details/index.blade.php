@extends('layouts.user')

@section('content')

<div class="card">
    <div class="card-header">
        <strong>{{ trans('cruds.ppmp.title_singular') }} {{ trans('global.list') }}</strong>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="ppmpTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ppmp.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp.fields.calendar_year') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp.fields.fund_source') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp.fields.budget_alloc') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="{{ $user_id }}"/>   
            <input type="hidden" name="hidden_fund_id" id="hidden_fund_id" value="{{ $fund_id }}"/>    
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>{{ trans('cruds.purchase_request.title_singular') }} {{ trans('global.list') }}</strong>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="purchase_requestTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.purchase_request.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request.fields.pr_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request.fields.purpose') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request.fields.fund_source') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.total_cost') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>{{ trans('cruds.purchase_order.title_singular') }} {{ trans('global.list') }}</strong>
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
                            {{ trans('cruds.purchase_order_item.fields.amount') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>{{ trans('cruds.fund_obligation.title_singular') }} {{ trans('global.list') }}</strong>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="fund_obligationTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.obr_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.reference') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.supplier') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.amount') }}
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
    var user_id = $('#hidden_user_id').val();  
    var fund_id = $('#hidden_fund_id').val();  
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], 
            pageLength: 15,
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
            dom: 'lrtip' 
        });

        // Function to initialize a DataTable
        function initializeDataTable(selector, ajaxUrl, columns, extraDefs = []) {
            return $(selector).DataTable({
                processing: true,
                serverSide: true,
                ajax: ajaxUrl + '?user_id=' + user_id + '&fund_id=' + fund_id, 
                columns: columns,
                columnDefs: [
                    { targets: 0, orderable: false, className: 'select-checkbox' },
                    ...extraDefs
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                createdRow: function (row, data) {
                    $(row).attr('data-entry-id', data.id);
                },
                // Ensure proper column adjustment after table is drawn
                drawCallback: function () {
                    // Adjust columns only after the table is fully drawn
                    setTimeout(function () {
                        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                    }, 100); // Adjust after a short delay
                },
                initComplete: function () {
                    // Make sure table is visible after DataTable is initialized
                    $(this).css('visibility', 'visible');
                }
            });
        }

        let ppmpTable = initializeDataTable('#ppmpTable', '{{ route('api.fund_allocation_ppmp_details.index') }}', [
            { data: null, defaultContent: "", orderable: false, className: 'select-checkbox' },
            { data: 'id', name: 'id' },
            { data: 'calendar_year', name: 'calendar_year' },
            { data: 'title', name: 'title', render: data => data ? `<span style="white-space:normal">${data}</span>` : '' },  
            { data: 'type', name: 'type' },
            { data: 'category', name: 'category' },
            { data: 'fund_source', name: 'fund_source' },
            { data: 'budget_alloc', name: 'budget_alloc', render: $.fn.dataTable.render.number(',', '.', 2)},       
        ], [
            { className: 'dt-right', targets: [7] },
            { className: 'dt-head-center', targets: [7] }
        ]);

        let purchase_requestTable = initializeDataTable('#purchase_requestTable', '{{ route('api.fund_allocation_pr_details.index') }}', [
            { data: null, defaultContent: "", orderable: false, className: 'select-checkbox' },
            { data: 'id', name: 'id' },
            { data: 'date', name: 'date' },
            { data: 'pr_no', name: 'pr_no' },
            { data: 'purpose', name: 'purpose', render: data => data ? `<span style="white-space:normal">${data}</span>` : '' },   
            { data: 'fund_source', name: 'fund_source', render: data => data ? `<span style="white-space:normal">${data}</span>` : '' },
            { data: 'purchase_request_item_sum_total_cost', name: 'purchase_request_item_sum_total_cost', render: $.fn.dataTable.render.number(',', '.', 2)}
        ], [
            { className: 'dt-right', targets: [6] },
            { className: 'dt-head-center', targets: [6] }
        ]);

        let purchase_orderTable = initializeDataTable('#purchase_orderTable', '{{ route('api.fund_allocation_po_details.index') }}', [
            { data: null, defaultContent: "", orderable: false, className: 'select-checkbox' },
            { data: 'id', name: 'id' },
            { data: 'date', name: 'date' },
            { data: 'po_no', name: 'po_no' },
            { data: 'pr_no', name: 'pr_no' },
            { data: 'purpose', name: 'purpose' },
            { data: 'supplier', name: 'supplier' },
            { data: 'mode', name: 'mode' },
            { data: 'purchase_order_item_sum_amount', name: 'purchase_order_item_sum_amount', render: $.fn.dataTable.render.number(',', '.', 2)}
        ], [
            { className: 'dt-right', targets: [8] },
            { className: 'dt-head-center', targets: [8] }
        ]);

        let fund_obligationTable = initializeDataTable('#fund_obligationTable', '{{ route('api.fund_obligation_details.index') }}', [
            { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
            { data: 'id', name: 'id' },
            { data: 'date', name: 'date' },
            { data: 'obr_no', name: 'obr_no' },
            { data: 'purchase_order.po_no', name: 'purchase_order.po_no', defaultContent: '' },
            { data: 'purchase_order.supplier.name', name: 'purchase_order.supplier.name', defaultContent: '' },
            { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2)},
        ], [
            { className: 'dt-right', targets: [6] },
            { className: 'dt-head-center', targets: [6] }
        ]);

        // ✅ Adjust tables on window resize
        $(window).on('resize', function () {
            // Redraw tables when resizing window (debounced)
            clearTimeout(window.resizeTimer);
            window.resizeTimer = setTimeout(function () {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            }, 200);
        });

        // ✅ Adjust tables after DataTable initialization
        $(document).ready(function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });
</script>

@endsection