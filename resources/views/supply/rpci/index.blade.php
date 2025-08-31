@extends('layouts.user')

@section('content')
@can('rpci_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('supply.rpci.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.rpci.title_short') }}
            </a>
            <a class="btn btn-secondary text-white" id="viewButton">
                {{ trans('global.view') }} {{ trans('cruds.rpci.title_short') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rpci.title_singular') }} {{ trans('global.list') }}
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
                                @foreach(\App\Models\Rpci::TYPE_SELECT as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>   
            <table class=" table table-bordered table-striped table-hover datatable" id="rpcppeTable">
                <thead>
                    <tr>
                        <th rowspan='2'>

                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpci.fields.id') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpci.fields.article') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpci.fields.description') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpci.fields.stock_no') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpci.fields.type') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpci.fields.unit') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.rpci.fields.unit_value') }}
                        </th>
                        <th rowspan='1' style="vertical-align:middle;">
                            {{ 'Balance Per' }} <br> {{ 'Card' }}
                        </th>
                        <th rowspan='1' style="vertical-align:middle;">
                            {{ 'Balance Per' }} <br> {{ 'Card' }}
                        </th>
                        <th colspan='2' style="text-align:center;">
                            {{ __('Shortage/Overage') }}
                        </th>
                        <th rowspan='2' style="text-align:center; vertical-align:middle;">
                            {{ trans('cruds.rpci.fields.remarks') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ 'Action' }}
                        </th>
                    </tr>
                    <tr> 
                            <th style="text-align:center;">
                                {{ 'Quantity' }}
                            </th>
                            <th style="text-align:center;">
                                {{ 'Quantity' }} 
                            </th>                       
                            <th style="text-align:center;">
                                {{ trans('cruds.rpci.fields.quantity_so') }}
                            </th>
                        <th style="text-align:center; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.rpci.fields.value_so') }}
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
        let table = $('#rpcppeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("api.rpci.index") }}',
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
                { data: 'stock_no', name: 'stock_no'},  
                { data: 'type', name: 'type'},
                { data: 'unit', name: 'unit' },
                { data: 'unit_value', name: 'unit_value' , render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'quantity_property_card', name: 'quantity_property_card' },
                { data: 'quantity_physical_count', name: 'quantity_physical_count' },
                { data: 'quantity_so', name: 'quantity_so' },
                { data: 'value_so', name: 'value_so' , render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'remarks', name: 'remarks' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('rpci_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('supply.rpci.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('rpci_edit')
                                <a class="btn btn-xs btn-info" href="{{ url('supply/rpci') }}/${data}/edit">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                            @can('rpci_delete')
                                <form action="{{ route('supply.rpci.destroy', '') }}/${data}" method="POST" 
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
                var baseUrl = "{{ url('supply/rpci_print') }}";

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