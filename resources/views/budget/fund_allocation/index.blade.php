@extends('layouts.user')

@section('content')
@can('fund_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('budget.fund_allocation.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fund.title_singular') }}
            </a>            
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fund.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="fundTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.particulars') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.fund_source') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.allotment_class') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.legal_basis') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.ppa') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.appropriation') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.obligated') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.unobligated') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.utilization_rate') }}
                        </th>
                        <th>
                            {{ trans('cruds.fund.fields.remarks') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="{{ $user_id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script> 
    var user_id = $('#hidden_user_id').val();  
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {
        // Define buttons for DataTable, including the delete functionality
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        @can('fund_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('budget.fund_allocation.massDestroy') }}",
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
        let table = $('#fundTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.fund_allocation.index') }}?user_id='+user_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'particulars', name: 'particulars', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }},
                { data: 'fund_source', name: 'fund_source' },
                { data: 'allotment_class', name: 'allotment_class' },
                { data: 'legal_basis', name: 'sub_aro_no' },  
                { data: 'ppa', name: 'ppa' },
                { data: 'appropriation', name: 'appropriation' },
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'obligated', name: 'obligated', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'unobligated', name: 'unobligated', render: $.fn.dataTable.render.number(',', '.', 2)},
                {
                    data: null,  
                    name: 'utilization_rate',
                    render: function(data, type, row) {
                        // Ensure amount and balance are valid numbers
                        var amount = parseFloat(row.amount) || 0; 
                        var obligated = parseFloat(row.obligated) || 0;

                        // Avoid division by zero
                        var utilization_rate = amount ? (obligated / amount) * 100 : 0;

                        // Format the result to 2 decimal places and append a percentage symbol
                        return utilization_rate.toFixed(2) + '%'; 
                    }
                },
                { data: 'remarks', name: 'remarks', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }},
                
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('fund_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('budget.fund_allocation.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('fund_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('budget/fund_allocation') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('fund_delete')
                                <form action="{{ route('budget.fund_allocation.destroy', '') }}/${data}" method="POST" 
                                    onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                    data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan
                            @can('fund_access')
                                <a class="btn btn-xs btn-success" href="{{ route('budget.fund_allocation_details.index2', '') }}/${data}">
                                    {{ trans('global.details') }}
                                </a>
                            @endcan
                            `;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1, 4, 13], visible: false },
                { className: 'dt-body-right', targets: [9, 10, 11, 12]},
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