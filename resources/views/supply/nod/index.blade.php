@extends('layouts.user')

@section('content')
@can('iar_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('supply.iar.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.iar.title_singular') }}
            </a>            
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.iar.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="iarTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.iar.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar.fields.nod_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar.fields.iar_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar.fields.reference') }} 
                        </th>
                        <th>
                            {{ trans('cruds.iar.fields.nod_invoice_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar.fields.supplier') }}
                        </th>
                        <th>
                            {{ trans('cruds.iar.fields.purpose') }}
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
        let table = $('#iarTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.nod.index') }}', // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'iar_no', name: 'iar_no' },
                { data: 'reference', name: 'reference' },
                { data: 'invoice_no', name: 'invoice_no' },
                { data: 'supplier', name: 'supplier' },
                { data: 'purpose', name: 'purpose' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('nod_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.nod.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('nod_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('supply/nod') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('nod_access')
                                <a class="btn btn-xs btn-success" href="{{ route('supply.nod_print', '') }}/${data}">
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

    });
</script>


@endsection