@extends('layouts.user')

@section('content')
<div class="form-group">
    <a class="btn btn-default" href="{{ route('supply.semi_expendable_hv_recipient.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <strong>{{ trans('cruds.ics_item.title_singular') }} {{ 'Items' }} {{ trans('global.list') }}</strong>
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
                            {{ trans('cruds.ics.fields.date') }}
                        </th>                       
                        <th>
                            {{ trans('cruds.ics.fields.ics_no') }}
                        </th>
                        <th>
                            {{ 'Qty.' }}
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
                            {{ trans('cruds.ics_item.fields.remarks') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_employee" id="hidden_employee" value="{{ $id }}"/>   
            <input type="hidden" name="hidden_role" id="hidden_role" value="{{ $role }}"/>   
        </div>
    </div>
</div>
<div class="form-group">
    <a class="btn btn-default" href="{{ route('supply.semi_expendable_hv_recipient.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
@endsection
@section('scripts')
@parent

<script>
    var id = $('#hidden_employee').val();   
    var role = $('#hidden_role').val();   
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
            ajax: '{{ route('api.semi_expendable_hv_received.index') }}?id='+id  + '&role=' + role, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'ics_hv_no', name: 'ics_hv_no' }, 
                { data: 'quantity', name: 'quantity' }, 
                { data: 'unit', name: 'unit' },
                { data: 'unit_cost', name: 'unit_cost', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'total_cost', name: 'total_cost', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'description', name: 'description'}, 
                { data: 'inventory_item_no', name: 'inventory_item_no' },
                { data: 'lifespan', name: 'lifespan' },
                { data: 'serial_no', name: 'serial_no' },
                { data: 'type', name: 'type' },
                { data: 'remarks', name: 'remarks' },
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [4, 6, 7, 10]},
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