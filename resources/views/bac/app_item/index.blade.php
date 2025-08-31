@extends('layouts.user')

@section('content')
@can('app_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('bac.app_item.create', $app_id) }}">
                {{ trans('global.add') }} {{ trans('cruds.ppmp.title_singular') }}
            </a>  
            <a class="btn btn-secondary" href="{{ route('bac.app_print', $app_id) }}">
                {{ trans('global.view') }} {{ trans('cruds.app.title_singular') }}
            </a>          
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.app_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="ppmpTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.ppmp') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.enduser') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.epa') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.mode') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.posting') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.noa') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.contract') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.fund_source') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.mooe_budget') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.co_budget') }}
                        </th>
                        <th>
                            {{ trans('cruds.app_item.fields.remarks') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_app_id" id="hidden_app_id" value="{{ $app_id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var app_id = $('#hidden_app_id').val();   
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
        let table = $('#ppmpTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.app_item.index') }}?app_id='+app_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'code', name: 'code' },
                { data: 'ppmp', name: 'ppmp'},
                { data: 'enduser', name: 'enduser' },
                { data: 'epa', name: 'epa' },
                { data: 'mode', name: 'mode' },
                { data: 'posting', name: 'posting' },
                { data: 'opening', name: 'opening' },
                { data: 'noa', name: 'noa' },
                { data: 'contract', name: 'contract' },
                { data: 'fund_source', name: 'fund_source' },
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2)},                
                { data: 'mooe_budget', name: 'mooe_budget', render: $.fn.dataTable.render.number(',', '.', 2)},                
                { data: 'co_budget', name: 'co_budget', render: $.fn.dataTable.render.number(',', '.', 2)},                
                { data: 'remarks', name: 'remarks' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('app_item_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('bac.app_item.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('app_item_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('bac/app_item') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('app_item_delete')
                                <form action="{{ route('bac.app_item.destroy', '') }}/${data}" method="POST" 
                                    onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                    data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan
                            @can('ppmp_item_access')
                                @if(!empty($data->ppmp_id))
                                    <a class="btn btn-xs btn-success" href="{{ route('bac.ppmp_item_final.index2', $data->ppmp_id) }}">
                                        {{ trans('global.item') }}
                                    </a>
                                @endif
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