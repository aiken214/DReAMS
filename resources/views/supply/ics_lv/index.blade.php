@extends('layouts.user')

@section('content')
@can('ics_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('supply.ics_lv.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.ics.title_singular') }}
            </a> 
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ics.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="risTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ics.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics.fields.ics_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics.fields.reference') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics.fields.entity_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics.fields.recipient') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics.fields.fund_cluster') }}
                        </th>
                        <th>
                            {{ trans('cruds.ics.fields.status') }}
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
        let table = $('#risTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.ics_lv.index') }}', // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'ics_lv_no', name: 'ics_lv_no' },
                { data: 'reference', name: 'reference' },
                { data: 'entity_name', name: 'entity_name' },
                { data: 'recipient', name: 'recipient' },
                { data: 'fund_cluster', name: 'fund_cluster' },
                { data: 'status', name: 'status' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('ics_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.ics_lv.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('ics_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('supply/ics_lv') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('ics_delete')
                                <form action="{{ route('supply.ics_lv.destroy', '') }}/${data}" method="POST" 
                                    onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                    data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan
                            @can('ics_item_access')
                                <a class="btn btn-xs btn-success" href="{{ route('supply.ics_item_lv.index2', '') }}/${data}">
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