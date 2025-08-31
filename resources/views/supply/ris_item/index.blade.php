@extends('layouts.user')

@section('content')
@can('ris_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('supply.ris_item.create2', $id) }}">
                {{ trans('global.add') }} {{ trans('cruds.ris_item.title_short') }}
            </a>
            <a class="btn btn-secondary" href="{{ route('supply.ris_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.ris.title_short') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ris_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="ris_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ris_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ris_item.fields.stock_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.ris_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.ris_item.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.ris_item.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.ris_item.fields.available') }}
                        </th>
                        <th>
                            {{ trans('cruds.ris_item.fields.issued_quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.ris_item.fields.remarks') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_ris_id" id="hidden_ris_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var ris_id = $('#hidden_ris_id').val();   
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
        let table = $('#ris_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.ris_item.index') }}?ris_id='+ris_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'stock_no', name: 'stock_no' }, 
                { data: 'unit', name: 'unit' },
                { data: 'description', name: 'description'}, 
                { data: 'issued_quantity', name: 'issued_quantity' },
                { data: 'available', name: 'available' },
                { data: 'issued_quantity', name: 'issued_quantity' },
                { data: 'remarks', name: 'remarks' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('ris_item_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.ris_item.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('ris_item_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('supply/ris_item') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('ris_item_delete')
                                <form action="{{ route('supply.ris_item.destroy', '') }}/${data}" method="POST" 
                                    onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                    data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan`;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [5, 6, 7]},
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