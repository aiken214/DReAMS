@extends('layouts.user')

@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-secondary" href="{{ route('user.ppmp_print', $id) }}">
            {{ trans('global.view') }} {{ trans('cruds.ppmp.title_singular') }}
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ppmp_item.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="ppmp_itemTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.budget') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.mode') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.jan') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.feb') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.mar') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.apr') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.may') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.jun') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.jul') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.aug') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.sep') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.oct') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.nov') }}
                        </th>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.dec') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tr>
                    <td colspan="22" style="border-top: 1px solid black">
                    <a style="margin-left:10px"> Allocated Budget:  &nbsp;&nbsp; <b> Php &nbsp;{{ number_format((float)$data->budget_alloc, 2, '.', ',') }}</b></a>
                    <a style="margin-left:30px"> Estimated Budget:  &nbsp;&nbsp; <b>Php &nbsp;{{ number_format((float)$sum_budget, 2, '.', ',') }}</b></a>
                    <a style="margin-left:30px"> Discrepancy:  &nbsp;&nbsp; <b>Php &nbsp;{{ number_format((float)$discrepancy, 2, '.', ',') }}</b></a>
                    </td>       
                </tr>    
            </table>
            <input type="hidden" name="hidden_ppmp_id" id="hidden_ppmp_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var ppmp_id = $('#hidden_ppmp_id').val();   
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {
        // Define buttons for DataTable, including the delete functionality
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons) //To display buttons like select all, deselect all, excel, pdf, print. Edit it in the layouts.use

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#ppmp_itemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.ppmp_item_approve.index') }}?ppmp_id='+ppmp_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'code', name: 'code' },
                { data: 'description', name: 'description', render: function ( data, type, row ) {
                    if (data) {
                        // Split the remarks into words
                        var words = data.split(' ');
                        // Get the first 10 words
                        var limitedWords = words.slice(0, 20).join(' ');
                        // Add ellipsis if there are more than 10 words
                        if (words.length > 10) {
                            limitedWords += '...';
                        }
                        return data ? '<span style="white-space:normal">' + limitedWords + '</span>' : ''; 
                    } else {
                        return '';
                    }
                }},  
                { data: 'unit', name: 'unit' },
                { data: 'quantity', name: 'quantity' },
                { data: 'cost', name: 'cost', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'budget', name: 'budget', render: $.fn.dataTable.render.number(',', '.', 2)},
                { data: 'mode', name: 'mode', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }},  
                { data: 'jan', name: 'jan' },                
                { data: 'feb', name: 'feb' },
                { data: 'mar', name: 'mar' },
                { data: 'apr', name: 'apr' },
                { data: 'may', name: 'may' },
                { data: 'jun', name: 'jun' },
                { data: 'jul', name: 'jul' },
                { data: 'aug', name: 'aug' },
                { data: 'sep', name: 'sep' },
                { data: 'oct', name: 'oct' },
                { data: 'nov', name: 'nov' },
                { data: 'dec', name: 'dec' },                
            ],
            columnDefs: [
                { targets: [1], visible: false },
                { orderable: false, targets: [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]},
                { className: 'dt-right', targets: [5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]},
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