@extends('layouts.user')

@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">          
        <a class="btn btn-secondary text-white" id="viewButton">
            {{ trans('global.view') }} {{ trans('global.checked') }} {{ trans('cruds.purchase_request.title_singular') }} {{ trans('global.list') }}
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchase_request.title_singular') }} {{ trans('global.list') }}
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
            <table class="table table-bordered table-striped table-hover datatable" id="purchase_requestTable">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.purchase_request.fields.id') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.date') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.pr_no') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.purpose') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.fund_source') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.office') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.requester') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.approved_date') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.amount') }}</th>
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

        let table = $('#purchase_requestTable').DataTable({
            processing: true,
            serverSide: true,    
            ajax: {
                url: '{{ route("api.purchase_request_check.checked") }}',
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
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'pr_no', name: 'pr_no' },
                { data: 'purpose', name: 'purpose', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }},   
                { data: 'fund_source', name: 'fund_source', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }}, 
                { data: 'office', name: 'office', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }}, 
                { data: 'requested_by', name: 'requested_by', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }},
                { 
                    data: 'checked', 
                    name: 'checked',
                    render: function(data, type, row) {
                        return data ? data.split(' ')[0] : '';
                    }
                },
                { data: 'total_cost_sum', name: 'total_cost_sum', render: $.fn.dataTable.render.number(',', '.', 2)},
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `@can('purchase_request_check_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('supply.purchase_request_check.show', '') }}/${data}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan
                            @can('purchase_request_item_check_access')
                            <a class="btn btn-xs btn-success" href="{{ route('supply.purchase_request_item_check.index2', '') }}/${data}">
                                {{ trans('global.item') }}
                            </a>
                            @endcan
                            @can('purchase_request_check_access')
                                ${(row.checked !== null && row.checked === null && row.remarks !== 'Request for PR reversal - End User.') ? `                                     
                                    <a class="btn btn-xs btn-warning approveIcon" data-id="${data}" data-bs-toggle="modal" data-bs-target="#approvePrModal">
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
                { className: 'dt-body-left', targets: [10], orderable: false }, 
                { className: 'dt-body-right', targets: [9], orderable: false }, 
                { targets: 0, orderable: false, className: 'select-checkbox' } // Checkbox for row selection
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
                var baseUrl = "{{ url('supply/checked_purchase_request_print') }}";

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
