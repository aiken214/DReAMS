@extends('layouts.user')

@section('content')
@can('rspi_access')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary text-white" id="viewButton">
                {{ trans('global.view') }} {{ trans('cruds.rspi.title_short') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rspi.title_singular') }} {{ trans('global.list') }}
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
            <table class=" table table-bordered table-striped table-hover datatable" id="rspiTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.ics_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.res_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.inventory_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.issued_quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.unit_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.rspi.fields.amount') }}
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
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons) //To display buttons like select all, deselect all, excel, pdf, print. Edit it in the layouts.user

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#rspiTable').DataTable({
            processing: true,
            serverSide: true,           
            ajax: {
                url: '{{ route("api.rspi_hv.index") }}',
                type: 'GET',
                data: function (d) {
                // read start date from the element
                d.from = $('#min').val();
                // read end date from the element
                d.to = $('#max').val();
                }
            },
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'ics_hv_no', name: 'ics_hv_no' },
                { data: 'res_code', name: 'res_code' },
                { data: 'inventory_item_no', name: 'inventory_item_no' },
                { data: 'description', name: 'description' },
                { data: 'unit', name: 'unit' },
                { data: 'quantity', name: 'quantity' },
                { data: 'unit_cost', name: 'unit_cost' },
                { data: 'total_cost', name: 'total_cost' },
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { className: 'dt-body-right', targets: [3, 7, 8, 9]},
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

        // Event listener for filtering when date inputs change
        $('#min, #max').on('change', function() {
            var from = $("#min").val();
            var to = $("#max").val();
            if(from && to) {
            table.draw();
            }
        });

        $(document).ready(function () {
            $('#viewButton').on('click', function () {
                var from = $('#min').val() || '';
                var to = $('#max').val() || '';

                var url = "{{ route('supply.rspi_hv_print', ['from' => ':from', 'to' => ':to']) }}";
                url = url.replace(':from', encodeURIComponent(from));
                url = url.replace(':to', encodeURIComponent(to));

                // Navigate to the updated URL
                window.location.href = url;
            });
        });
    });
</script>


@endsection