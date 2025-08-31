@extends('layouts.user')

@section('content')
@can('par_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('supply.iirusp_item.create2', $id) }}">
                {{ trans('global.add') }} {{ trans('cruds.iirusp_item.title_short') }}
            </a> 
            <a class="btn btn-primary" href="{{ route('supply.iirusp_item.create_from_rpcsp', $id) }}">
                {{ trans('global.add') }} {{ trans('cruds.iirusp_item.title_short') }} {{ 'from RPCSP' }}
            </a> 
            <a class="btn btn-secondary" href="{{ route('supply.iirusp_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.iirusp.title_short') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.iirup_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="iirup_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.date_acquired') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.particulars') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.semi_expendable_property_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.unit_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.total_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.depreciation') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.losses') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.carrying_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.remarks') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.sale') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.transfer') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.destruction') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.others') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.total_dispose') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.appraised_value') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.or_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.iirup_item.fields.amount') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_iirusp_id" id="hidden_iirusp_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var iirusp_id = $('#hidden_iirusp_id').val();   
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
        let table = $('#iirup_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.iirusp_item.index') }}?iirusp_id='+iirusp_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date_acquired', name: 'date_acquired' }, 
                { data: 'particulars', name: 'particulars' },
                { data: 'semi_expendable_property_no', name: 'semi_expendable_property_no' },
                { data: 'quantity', name: 'quantity'}, 
                { data: 'unit_cost', name: 'unit_cost', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'total_cost', name: 'total_cost', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'depreciation', name: 'depreciation', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'losses', name: 'losses', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'carrying_amount', name: 'carrying_amount', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'remarks', name: 'remarks' },
                { data: 'sale', name: 'sale', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'transfer', name: 'transfer', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'destruction', name: 'destruction', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'others', name: 'others', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'total_dispose', name: 'total_dispose', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'appraised_value', name: 'appraised_value', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'or_no', name: 'or_no' },
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2)},
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('iirusp_item_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.iirusp_item.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('iirusp_item_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('supply/iirusp_item') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan`;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [2, 4]},
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