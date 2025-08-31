@extends('layouts.user')

@section('content')
<div class="form-group">
    <a class="btn btn-default" href="{{ route('supply.ppe_recipient.index') }}">
        {{ trans('global.back_to_list') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        <strong>{{ trans('cruds.par_item.title_singular') }} {{ 'Items' }} {{ trans('global.list') }}</strong>
    </div>
    <div class="card-body">
        
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="par_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.id') }}
                        </th>                        
                        <th>
                            {{ trans('cruds.par.fields.date') }}
                        </th>                       
                        <th>
                            {{ trans('cruds.par.fields.par_no') }}
                        </th>
                        <th>
                            {{ 'Qty.' }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.property_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.date_acquired') }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.serial_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.remarks') }}
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
    <a class="btn btn-default" href="{{ route('supply.ppe_recipient.index') }}">
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
        let table = $('#par_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.ppe_received.index') }}?id=' + id + '&role=' + role, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'par_no', name: 'par_no' }, 
                { data: 'quantity', name: 'quantity' }, 
                { data: 'unit', name: 'unit' },
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'description', name: 'description'}, 
                { data: 'property_no', name: 'property_no' },
                { data: 'date_acquired', name: 'date_acquired' },
                { data: 'serial_no', name: 'serial_no' },
                { data: 'type', name: 'type' },
                { data: 'remarks', name: 'remarks' },
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [4, 6]},
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