@extends('layouts.user')

@section('content')

<style>
   .expandable {
    display: inline-block;
    max-width: 80ch; /* Limit width to 80 characters */
    height: 100px; /* Limit height initially */
    overflow: hidden; /* Hide the content that overflows */
    white-space: normal; /* Allow text wrapping */
    text-overflow: ellipsis; /* Add ellipsis for overflowed content */
    cursor: pointer; /* Show pointer cursor to indicate it's expandable */
    transition: all 0.3s ease-in-out;
    line-height: 1.5; /* Make sure text doesn't overlap */
    padding: 5px; /* Optional: Add padding for better look */
    }

    .expandable.expanded {
        height: auto; /* Expand the height when clicked */
        background-color: #f0f0f0; /* Optional: Change background when expanded */
        padding: 10px; /* Optional: Add padding to make it more readable */
    }

</style>

@can('rspi_access')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary text-white" id="viewButton">
                {{ trans('global.view') }} {{ trans('cruds.regspi.title_short') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.regspi.title_singular') }} {{ trans('global.list') }}
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
            <table class=" table table-bordered table-striped table-hover datatable" id="regspiTable">
                <thead>
                    <tr>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.regspi.fields.id') }}
                        </th>
                        <th rowspan='2' style="text-align:center; vertical-align:middle;">
                            {{ trans('cruds.regspi.fields.date') }}
                        </th>
                        <th colspan='2' style="text-align:center;">
                            {{ trans('cruds.regspi.fields.reference') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.regspi.fields.description') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.regspi.fields.type') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle;">
                            {{ trans('cruds.regspi.fields.lifespan') }}
                        </th>
                        <th colspan='2' style="text-align:center;">
                            {{ trans('cruds.regspi.fields.issued') }}
                        </th>
                        <th colspan='2' style="text-align:center;">
                            {{ trans('cruds.regspi.fields.returned') }}
                        </th>
                        <th colspan='2' style="text-align:center;">
                            {{ trans('cruds.regspi.fields.reissued') }}
                        </th>
                        <th rowspan='1' style="text-align:center;">
                            {{ trans('cruds.regspi.fields.disposed') }}
                        </th>
                        <th rowspan='1' style="text-align:center;">
                            {{ trans('cruds.regspi.fields.balance') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle; text-align:center;">
                            {{ trans('cruds.regspi.fields.amount') }}
                        </th>
                        <th rowspan='2' style="vertical-align:middle; text-align:center;">
                            {{ trans('cruds.regspi.fields.remarks') }}
                        </th>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.ref_no') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.inventory_item_no') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.quantity') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.office') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.quantity') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.office') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.quantity') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.office') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.quantity') }}
                        </th>
                        <th style="vertical-align:middle; border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.regspi.fields.quantity') }}
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
    $(document).ready(function () {
        // Toggle 'expanded' class on click for the expandable description cells
        $('.expandable').click(function () {
            // Toggle the 'expanded' class to expand/collapse the description
            $(this).toggleClass('expanded');
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Attach the click event dynamically to the table
        $('#regspiTable').on('click', '.expandable', function () {
            // Toggle the 'expanded' class to expand/collapse the description
            $(this).toggleClass('expanded');
        });

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[1, 'desc']],
            pageLength: 15,
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        let table = $('#regspiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("api.regspi_hv.index") }}',
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
            buttons: dtButtons,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'reference', name: 'reference' },
                { data: 'property_no', name: 'property_no' },
                {
                    data: 'description', 
                    name: 'description',
                    render: function(data, type, row) {
                        return `<div class="expandable">${data}</div>`; // Apply expandable class to description
                    }
                },
                { data: 'type', name: 'type' },
                { data: 'lifespan', name: 'lifespan' },
                { data: 'issued_qty', name: 'issued_qty' },
                { data: 'issued_office', name: 'issued_office',
                    render: function ( data, type, row ) {
                      return data.split(",").join("<br/>");
                      }}, 
                { data: 'returned_qty', name: 'returned_qty' },
                { data: 'returned_office', name: 'returned_office', 
                    render: function ( data, type, row ) {
                      return data.split(",").join("<br/>");
                      }},
                { data: 're-issued_qty', name: 're-issued_qty' },
                { data: 're-issued_office', name: 're-issued_office', 
                    render: function ( data, type, row ) {
                      return data.split(",").join("<br/>");
                      }},
                { data: 'disposed_qty', name: 'disposed_qty' },
                { data: 'balance_qty', name: 'balance_qty' },
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2, '')},
                { data: 'remarks', name: 'remarks' },
            ],
            columnDefs: [
                { targets: [0, 5], visible: false },
                { className: 'dt-body-right', targets: [7, 9, 11, 13, 14, 15]},
                { className: 'dt-body-center', targets: [8, 10, 12]},
                { targets: [4], width: "200px" }, // Column index for description
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
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
                var baseUrl = "{{ url('supply/regspi_hv_print') }}";

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