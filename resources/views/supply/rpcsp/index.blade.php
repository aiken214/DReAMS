@extends('layouts.user')

@section('content')
@can('rpcsp_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('supply.rpcsp.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.rpcsp.title_short') }}
            </a>
            <a class="btn btn-primary" href="{{ route('supply.rpcsp.create_from_ics_hv') }}">
                {{ trans('global.add') }} {{ trans('cruds.rpcsp.title_short') }} {{'from ICS-HV'}}
            </a>  
            <a class="btn btn-secondary text-white" id="viewButton">
                {{ trans('global.view') }} {{ trans('cruds.rpcsp.title_short') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rpcsp.title_singular') }} {{ trans('global.list') }}
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

                        <td width="20px"></td>

                        <td>Type:</td>
                        <td>
                            <select id="typeFilter">
                                <option value="">All</option>
                                @foreach(\App\Models\Rpcsp::TYPE_SELECT as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>   
            <table class=" table table-bordered table-striped table-hover datatable" id="rpcspTable">
                <thead>
                    <tr>
                        <th rowspan='2'>

                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.id') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.article') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.description') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.sp_property_no') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.type') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.unit') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.unit_value') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.quantity_property_card') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.quantity_physical_count') }}
                        </th>
                        <th colspan='2' style="text-align:center;">
                            {{ __('Shortage/Overage') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpcsp.fields.remarks') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ 'Action' }}
                        </th>
                    </tr>
                    <tr>                        
                        <th>
                            {{ trans('cruds.rpcsp.fields.quantity_so') }}
                        </th>
                        <th style="border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.rpcsp.fields.value_so') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                    <tr>                        
                        <td colspan="5" style="text-align:center; border: 1px solid #D3D3D3;">
                            {{ 'Total' }}
                        </td>
                        <td id="totalCostDisplay" style="border: 1px solid #D3D3D3; text-align:right;">
                            ₱0.00
                        </td>
                        <td colspan="6" style="text-align:center; border: 1px solid #D3D3D3;">
                            {{ '' }}
                        </td>
                    </tr>
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
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons) //To display buttons like select all, deselect all, excel, pdf, print. Edit it in the layouts.user

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#rpcspTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("api.rpcsp.index") }}',
                type: 'GET',
                data: function (d) {
                // read start date from the element
                d.from = $('#min').val();
                // read end date from the element
                d.to = $('#max').val();
                // Add this line to pass the selected type
                d.type = $('#typeFilter').val();  
                }
            },
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'article', name: 'article' },
                { data: 'description', name: 'description'},  
                { data: 'sp_property_no', name: 'sp_property_no'},  
                { data: 'type', name: 'type'},
                { data: 'unit', name: 'unit' },
                {
                    data: 'unit_value',
                    name: 'unit_value',
                    render: function (data, type, row) {
                        // Try converting to a float
                        let num = parseFloat(data.toString().replace(/,/g, ''));

                        // If it's not a number, return the original (e.g., 'N/A')
                        if (isNaN(num)) return data;

                        // Format the number with commas and 2 decimal places
                        return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                },
                { data: 'quantity_property_card', name: 'quantity_property_card' },
                { data: 'quantity_physical_count', name: 'quantity_physical_count' },
                { data: 'quantity_so', name: 'quantity_so' },
                { data: 'value_so', name: 'value_so' , render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'remarks', name: 'remarks' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('rpcsp_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.rpcsp.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('rpcsp_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('supply/rpcsp') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('rpcsp_delete')
                                <form action="{{ route('supply.rpcsp.destroy', '') }}/${data}" method="POST" 
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
                { targets: [1, 5], visible: false },
                { className: 'dt-body-right', targets: [7, 8, 9, 10, 11]},
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

        table.on('xhr', function () {
            var json = table.ajax.json();
            if (json.totalCost !== undefined) {
                $('#totalCostDisplay').text('₱' + parseFloat(json.totalCost).toLocaleString(undefined, {minimumFractionDigits: 2}));
            }
        });
        
        // Event listener for filtering when date inputs change
        $('#min, #max, #typeFilter').on('change', function() {
            table.draw(); // Redraw the table whenever any filter changes
        });

        $(document).ready(function () {
            $('#viewButton').on('click', function () {
                var from = $('#min').val().trim();
                var to = $('#max').val().trim();
                var type = $('#typeFilter').val().trim();

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
                var baseUrl = "{{ url('supply/rpcsp_print') }}";

                // Initialize an array to hold the parameters
                var params = [];
                
                // Add dates and type to the parameters array
                params.push(encodeURIComponent(from));
                params.push(encodeURIComponent(to));
                if (type) params.push(encodeURIComponent(type));

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