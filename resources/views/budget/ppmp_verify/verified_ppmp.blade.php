@extends('layouts.user')

@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">          
        <a class="btn btn-secondary text-white" id="viewButton">
            {{ trans('global.view') }} {{ trans('global.verified') }} {{ trans('cruds.ppmp.title_singular') }} {{ trans('global.list') }}
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
    {{ trans('global.verified') }} {{ trans('cruds.ppmp.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table border="0" cellspacing="5" style="font-size:14px; margin-bottom: 30px">
                <tbody>
                    <tr>
                        <td>Start date:</td>
                        <td><input type="date" id="min" name="min"></td>
                    
                        <td width="20px"></td>

                        <td>End date:</td>
                        <td><input type="date" id="max" name="max"></td>
                    </tr>
                </tbody>
            </table>   
            <table class="table table-bordered table-striped table-hover datatable" id="ppmpTable">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.ppmp.fields.id') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.calendar_year') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.title') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.type') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.category') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.requester') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.station') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.fund_source') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.budget_alloc') }}</th>
                        <th>{{ 'Action' }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
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
            ajax: {
                url: '{{ route("api.ppmp_verify.verified") }}',
                type: 'GET',
                data: function (d) {
                // read start date from the element
                d.from = $('#min').val();
                // read end date from the element
                d.to = $('#max').val();
                }
            },
            buttons: dtButtons,
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' },
                { data: 'id', name: 'id' },
                { data: 'calendar_year', name: 'calendar_year' },
                { data: 'title', name: 'title', render: function (data) { return data ? '<span style="white-space:normal">' + data + '</span>' : ''; }},
                { data: 'type', name: 'type' },
                { data: 'category', name: 'category' },
                { data: 'prepared_by', name: 'prepared_by', render: function (data) { return data ? '<span style="white-space:normal">' + data + '</span>' : ''; }},
                { data: 'station', name: 'station', render: function (data) { return data ? '<span style="white-space:normal">' + data + '</span>' : ''; }},
                { data: 'fund_source', name: 'fund_source' },
                { data: 'budget_alloc', name: 'budget_alloc', render: $.fn.dataTable.render.number(',', '.', 2)},
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `@can('ppmp_verify_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('budget.ppmp_verify.show', '') }}/${data}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan
                            @can('ppmp_item_verify_access')
                            <a class="btn btn-xs btn-success" href="{{ route('budget.ppmp_item_verify.index2', '') }}/${data}">
                                {{ trans('global.item') }}
                            </a>
                            @endcan
                            @can('ppmp_verify_access')
                                ${(row.checked !== null && row.verified === null && row.remarks !== 'Request for PPMP reversal - End User.') ? `                                    
                                    <a class="btn btn-xs btn-warning approveIcon" data-id="${data}" data-bs-toggle="modal" data-bs-target="#approvePpmpModal">
                                        {{ trans('global.approve') }}
                                    </a>
                                ` : ''}
                            @endcan`;
                    },
                    orderable: false 
                }               
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-center', targets: [10], orderable: false }, // Adjust based on index of action column
                { className: 'dt-body-right', targets: [9]},
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
        
        // Event listener for filtering when date inputs change
        $('#min, #max').on('change', function() {
            table.draw(); // Redraw the table whenever any filter changes
        });

        $(document).ready(function () {
            $('#viewButton').on('click', function () {
                var from = $('#min').val().trim();
                var to = $('#max').val().trim();

                // Get current year
                var currentYear = new Date().getFullYear();

                // Set default values for start and end dates if not provided
                if (!from) {
                    from = currentYear + '-01-01'; // Default to January 1st of the current year
                }
                if (!to) {
                    to = currentYear + '-12-31'; // Default to December 31st of the current year
                }

                // Base URL without parameters
                var baseUrl = "{{ url('budget/verified_ppmp_print') }}";

                // Initialize an array to hold the parameters
                var params = [];
                
                // Add dates and type to the parameters array
                params.push(encodeURIComponent(from));
                params.push(encodeURIComponent(to));

                // Construct the final URL by joining parameters with '/' only if there are parameters
                var finalUrl = baseUrl + '/' + params.join('/');

                console.log(finalUrl); // Debug: Check the constructed URL in the browser console

                // Navigate to the updated URL
                window.location.href = finalUrl;
            });
        });

    });
</script>

@endsection
