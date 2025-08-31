@extends('layouts.user')

@section('content')
@can('rrppe_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('supply.rrppe.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.rrppe.title_short') }}
            </a> 
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rrppe.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="rrppeTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.rrppe.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.rrppe.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.rrppe.fields.rrppe_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.rrppe.fields.reference') }}
                        </th>
                        <th>
                            {{ trans('cruds.rrppe.fields.entity_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.rrppe.fields.recipient') }}
                        </th>
                        <th>
                            {{ trans('cruds.rrppe.fields.remarks') }}
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
        let table = $('#rrppeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.rrppe.index') }}', // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'rrppe_no', name: 'rrppe_no' },
                { data: 'reference', name: 'reference' },
                { data: 'par.entity_name', name: 'par.entity_name' },
                { data: 'par.recipient', name: 'par.recipient' },
                { data: 'status', name: 'status' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('rrppe_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.rrppe.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('rrppe_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('supply/rrppe') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('rrppe_delete')
                                <form action="{{ route('supply.rrppe.destroy', '') }}/${data}" method="POST" 
                                    onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                    data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan
                            @can('rrppe_item_access')
                                <a class="btn btn-xs btn-success" href="{{ route('supply.rrppe_item.index2', '') }}/${data}">
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