@extends('layouts.user')

@section('content')
@can('app_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @if(empty($finalized) || !$finalized)
                <a class="btn btn-success" href="{{ route('bac.app_non_cse.create2', $app_id) }}">
                    {{ trans('global.add') }} {{ trans('cruds.ppmp.title_singular') }} {{ '- Non-CSE'}}
                </a>
            @endif
                <a class="btn btn-secondary" href="{{ route('bac.app_non_cse_print', $app_id) }}">
                    {{ trans('global.view') }} {{ trans('cruds.app.title_singular') }}
                </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ppmp.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable" id="ppmpTable">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.ppmp.fields.id') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.calendar_year') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.title') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.type') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.requester') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.station') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.fund_source') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.budget_alloc') }}</th>
                        <th>{{ 'Action' }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
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

    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]],
            pageLength: 15,
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        let table = $('#ppmpTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.app_non_cse.index') }}?app_id='+app_id, // Your API route
            buttons: dtButtons,
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' },
                { data: 'id', name: 'id' },
                { data: 'calendar_year', name: 'calendar_year' },
                { data: 'title', name: 'title', render: function (data) { return data ? '<span style="white-space:normal">' + data + '</span>' : ''; }},
                { data: 'type', name: 'type' },
                { data: 'prepared_by', name: 'prepared_by', render: function (data) { return data ? '<span style="white-space:normal">' + data + '</span>' : ''; }},
                { data: 'station', name: 'station', render: function (data) { return data ? '<span style="white-space:normal">' + data + '</span>' : ''; }},
                { data: 'fund_source', name: 'fund_source' },
                { data: 'budget_alloc', name: 'budget_alloc', render: $.fn.dataTable.render.number(',', '.', 2)},
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `@can('app_non_cse_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('bac.app_non_cse.show', '') }}/${data}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan
                            @can('app_non_cse_delete')
                                ${row.finalized === null ? `
                                    <form action="{{ route('bac.app_non_cse.destroy', '') }}/${data}" method="POST" 
                                        onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                        data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                ` : ''}
                            @endcan     `;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { targets: 0, orderable: false, className: 'select-checkbox' }
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            createdRow: function (row, data) {
                $(row).attr('data-entry-id', data.id);
            }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });


    });
</script>

@endsection
