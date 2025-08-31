@extends('layouts.user')

@section('content')
@can('purchase_order_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('bac.purchase_order_item.create2', $id) }}">
                {{ trans('global.add') }} {{ trans('cruds.purchase_order_item.title_singular') }}
            </a>
            <a class="btn btn-secondary" href="{{ route('bac.purchase_order_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.purchase_order.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchase_order_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="purchase_order_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.stock_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.unit_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.amount') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_purchase_order_id" id="hidden_purchase_order_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var purchase_order_id = $('#hidden_purchase_order_id').val();   
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {
        // Define buttons for DataTable, including the delete functionality
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons) //To display buttons like select all, deselect all, excel, pdf, print. Edit it in the layouts.user

        @can('purchase_order_item_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('bac.purchase_order_item.massDestroy') }}",
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
        // @endcan

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#purchase_order_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.purchase_order_item.index') }}?purchase_order_id='+purchase_order_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'stock_no', name: 'stock_no' },
                { data: 'description', name: 'description'},  
                { data: 'unit', name: 'unit' },
                { data: 'quantity', name: 'quantity' },
                { data: 'unit_cost', name: 'unit_cost', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2)},
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('purchase_order_item_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('bac.purchase_order_item.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('purchase_order_item_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('bac/purchase_order_item') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('purchase_order_item_delete')
                                <form action="{{ route('bac.purchase_order_item.destroy', '') }}/${data}" method="POST" 
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