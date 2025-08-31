@extends('layouts.user')

@section('content')
@can('purchase_order_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('bac.purchase_order.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.purchase_order.title_singular') }}
            </a>            
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchase_order.title_singular') }} {{ trans('global.list') }}
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
                            {{ trans('cruds.purchase_order.fields.delivery') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order.fields.term') }}
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

        @can('purchase_order_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('bac.purchase_order.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: { 'x-csrf-token': _token },
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    })
                    .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#purchase_orderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.purchase_order.index') }}', // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'po_no', name: 'po_no' },
                { data: 'pr_no', name: 'pr_no' },
                { data: 'purpose', name: 'purpose' },
                { data: 'supplier', name: 'supplier' },
                { data: 'mode', name: 'mode' },
                { data: 'delivery', name: 'delivery' },
                { data: 'term', name: 'term' },                
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('purchase_order_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('bac.purchase_order.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('purchase_order_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('bac/purchase_order') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('purchase_order_delete')
                                <form action="{{ route('bac.purchase_order.destroy', '') }}/${data}" method="POST" 
                                    onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                    data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan
                            @can('purchase_order_item_access')
                                <a class="btn btn-xs btn-success" href="{{ route('bac.purchase_order_item.index2', '') }}/${data}">
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

        // Ensure table columns adjust on tab switching
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

    });
</script>


@endsection