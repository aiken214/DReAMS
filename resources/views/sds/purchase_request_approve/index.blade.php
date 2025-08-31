@extends('layouts.user')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchase_request.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
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
                        <th>{{ trans('cruds.purchase_request.fields.status') }}</th>
                        <th>{{ trans('cruds.purchase_request.fields.remarks') }}</th>
                        <th>{{ 'Action' }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Approving Purchase Request -->
<div id="approvePrModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Purchase Request Approval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="approvePrForm" enctype="multipart/form-data" class="form-horizontal">
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
                    <button type="submit" id="edit_purchaseRequest_btn" class="btn btn-primary">Save</button>
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

        let table = $('#purchase_requestTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.purchase_request_approve.index') }}',
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
                        return `@can('purchase_request_approve_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('sds.purchase_request_approve.show', '') }}/${data}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan
                            @can('purchase_request_item_approve_access')
                            <a class="btn btn-xs btn-success" href="{{ route('sds.purchase_request_item_approve.index2', '') }}/${data}">
                                {{ trans('global.item') }}
                            </a>
                            @endcan
                            @can('purchase_request_approve_access')
                                ${(row.verified !== null && row.approved === null && row.remarks !== 'Request for PR reversal - End User.') ? `                                     
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

        $(document).on('click', '.approveIcon', function () {
            const purchaseRequestId = $(this).data('id');
            // console.log('Approve clicked for ID:', purchaseRequestId); // Check if this is logged
            $('#approvePrForm #id').val(purchaseRequestId);
            $("#approvePrModal").modal('show'); // Explicitly show the modal
        });

        $(document).on('click', '#close', function () {
            $("#approvePrModal").modal('hide');
        });

        $("#approvePrForm").submit(function (e) {
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: '{{ route('sds.purchase_request_approve.approve', '') }}/' + $('#approvePrForm #id').val(),
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
                        'Purchase Request Approved Successfully!',
                        'success'
                    )
                    $('#purchase_requestTable').DataTable().ajax.reload(null, false);
                    }
                    $("#approvePrForm")[0].reset();
                    $("#approvePrModal").modal('hide');
                }
            });
        });

        // Revert Data ajax request
        $(document).on('click', '.revertIcon', function(e) {        
            e.preventDefault();
            let url = $(this).attr('href');  // Get the href attribute directly
            let id = url.split('/').pop();  // Extract the ID from the URL
            let csrf = '{{ csrf_token() }}';  // CSRF token
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to revert the selected Purchase Request!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, revert it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,  // Use the full URL for the AJAX call
                    method: 'POST',
                    data: {
                        id: id,
                        _token: csrf
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire(
                    'Submitted!',
                    'Your request for Purchase Request reversal has been submitted.',
                    'success'
                    )
                    $('#purchase_requestTable').DataTable().ajax.reload(null, false);
                }
                });
            }
            })
        });    

    });
</script>

@endsection
