@extends('layouts.user')

@section('content')
@can('ics_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary" href="{{ route('supply.ics_hv_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.ics.title_short') }}
            </a>
            @if($risCount > 1)
                <a class="btn btn-secondary" href="{{ route('supply.ics_hv_consol_print', $id) }}">
                    {{ trans('global.view') }} {{ 'Consolidated' }} {{ trans('cruds.ics.title_short') }}
                </a>
            @endif
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ics_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="ics_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.unit_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.total_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.inventory_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.lifespan') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.serial_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics_item.fields.type') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_ics_hv_id" id="hidden_ics_hv_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var ics_hv_id = $('#hidden_ics_hv_id').val();   
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
        let table = $('#ics_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.ics_item_hv.index') }}?ics_hv_id='+ics_hv_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'quantity', name: 'quantity' }, 
                { data: 'unit', name: 'unit' },
                { data: 'unit_cost', name: 'unit_cost', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'total_cost', name: 'total_cost', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'description', name: 'description'}, 
                { data: 'inventory_item_no', name: 'inventory_item_no' },
                { data: 'lifespan', name: 'lifespan' },
                { data: 'serial_no', name: 'serial_no' },
                { data: 'type', name: 'type' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('ics_item_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.ics_item_hv.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('ics_item_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('supply/ics_item_hv') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan`;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [2, 4, 5, 8, 9]},
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