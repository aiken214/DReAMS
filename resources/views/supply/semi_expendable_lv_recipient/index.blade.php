@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <strong>{{ trans('cruds.common.fields.high_value') }} {{ trans('cruds.semi_expendable.title_singular') }} {{ trans('cruds.common.fields.property') }} {{ 'Recipients' }} </strong>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="recipientTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.fullname') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.position') }}
                        </th>
                        <th>
                            {{ trans('cruds.station.fields.station_name') }}
                        </th>
                        <th>
                            {{ 'Action' }}
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
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        let table = $('#recipientTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('api.semi_expendable_lv_recipient.index') }}', // Your API route
                buttons: dtButtons, // Include delete buttons
                columns: [
                    // Define your columns based on the data you're receiving
                    { data: null, "defaultContent": "" },
                    { data: 'recipient'},
                    { data: 'designation'},
                    { data: 'entity_name'},
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            return `
                                @can('recipient_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('supply.semi_expendable_lv_recipient.show', '') }}/${data}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan`;
                        }
                    },
                ],
                columnDefs: [
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
        });


</script>
@endsection