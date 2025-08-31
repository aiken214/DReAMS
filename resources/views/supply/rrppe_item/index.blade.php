@extends('layouts.user')

@section('content')
@can('rrsp_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary" href="{{ route('supply.rrppe_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.rrppe.title_short') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.par_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="rrppe_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.par_item.fields.quantity') }}
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
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_rrppe_id" id="hidden_rrppe_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var rrppe_id = $('#hidden_rrppe_id').val();   
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
        let table = $('#rrppe_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.rrppe_item.index') }}?rrppe_id='+rrppe_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'quantity', name: 'quantity' }, 
                { data: 'unit', name: 'unit' },
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2) },
                { data: 'description', name: 'description'}, 
                { data: 'property_no', name: 'property_no' },
                { data: 'date_acquired', name: 'date_acquired' },
                { data: 'serial_no', name: 'serial_no' },
                { data: 'type', name: 'type' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('rrppe_item_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.rrppe_item.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan`;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [2, 3, 4, 7, 8]},
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