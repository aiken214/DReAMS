@extends('layouts.user')

@section('content')
@can('ppmp_verify_access')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('budget.ppmp_verify.verified') }}">
                {{ trans('global.verified') }} {{ trans('cruds.ppmp.title_singular') }} {{ trans('global.list') }}
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
                        <th>{{ trans('cruds.ppmp.fields.category') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.requester') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.station') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.fund_source') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.budget_alloc') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.status') }}</th>
                        <th>{{ trans('cruds.ppmp.fields.remarks') }}</th>
                        <th>{{ 'Action' }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Approving PPMP -->
<div id="approvePpmpModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PPMP Approval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="approvePpmpForm" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_checked" class="form-label">Approve</label>
                        <select class="form-control" id="edit_checked" name="edit_checked" required>
                            <option value="" disabled selected>Select...</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="edit_remarks" name="edit_remarks" placeholder="If No, please provide remarks."></textarea>
                        <span class="text-danger error-text date_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="edit_Ppmp_btn" class="btn btn-primary">Save</button>
                    <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
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
            ajax: '{{ route('api.ppmp_verify.index') }}',
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
                    data: null,
                    name: 'status',
                    render: function(data, type, row) {
                        if (row.added) return '<a class="btn btn-xs btn-success text-white">Added</a>';
                        if (row.approved) return '<a class="btn btn-xs btn-success text-white">Approved</a>';
                        if (row.verified) return '<a class="btn btn-xs btn-success text-white">Verified</a>';
                        if (row.checked) return '<a class="btn btn-xs btn-success text-white">Checked</a>';
                        if (row.finalized) return '<a class="btn btn-xs btn-success text-white">Pending</a>';
                        return '<a class="btn btn-xs btn-warning text-white">Preparation</a>';
                }},
                { data: 'remarks', name: 'remarks' },
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
                                ${(row.checked !== null && row.remarks !== 'Request for PPMP reversal - End User.') ? `                                    
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
                { className: 'dt-left', targets: [12], orderable: false }, 
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

        $(document).on('click', '.approveIcon', function () {
            const ppmpId = $(this).data('id');
            // console.log('Approve clicked for ID:', ppmpId); // Check if this is logged
            $('#approvePpmpForm #id').val(ppmpId);
            $("#approvePpmpModal").modal('show'); // Explicitly show the modal
        });

        $(document).on('click', '#close', function () {
            $("#approvePpmpModal").modal('hide');
        });

        $("#approvePpmpForm").submit(function (e) {
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: '{{ route('budget.ppmp_verify.approve', '') }}/' + $('#approvePpmpForm #id').val(),
                method: "POST",
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                    Swal.fire(
                        'Updated!',
                        'PPMP Updated Successfully!',
                        'success'
                    )
                    $('#ppmpTable').DataTable().ajax.reload(null, false);
                    }
                    $("#approvePpmpForm")[0].reset();
                    $("#approvePpmpModal").modal('hide');
                }
            });
        });

    });
</script>

@endsection
