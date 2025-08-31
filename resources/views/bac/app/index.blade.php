@extends('layouts.user')

@section('content')
@can('app_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('bac.app.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.app.title_singular') }}
            </a>            
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.app.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="appTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.app.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.app.fields.calendar_year') }}
                        </th>
                        <th>
                            {{ trans('cruds.app.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.app.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.app.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.app.fields.remarks') }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="{{ $user_id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var user_id = $('#hidden_user_id').val();   
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {
        // Define buttons for DataTable, including the delete functionality
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        
        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#appTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.app.index') }}?user_id='+user_id, // Your API route
            buttons: dtButtons, // Include delete buttons
            columns: [
                { data: null, "defaultContent": "", orderable: false, className: 'select-checkbox' }, // Checkbox column
                { data: 'id', name: 'id' },
                { data: 'calendar_year', name: 'calendar_year' },
                { data: 'title', name: 'title', render: function ( data, type, row ) {
                    return data ? '<span style="white-space:normal">' + data + '</span>' : ''; 
                }},  
                { data: 'type', name: 'type' },
                { data: 'category', name: 'category' },
                
                { data: 'remarks', name: 'remarks' },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @can('app_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('bac.app.show', '') }}/${data}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
                            @can('app_edit')
                                ${row.finalized === null ? `
                                    <a class="btn btn-xs btn-info" href="{{ url('bac/app') }}/${data}/edit">
                                        {{ trans('global.edit') }}
                                    </a>
                                ` : ''}
                            @endcan
                            @can('app_delete')
                                ${row.finalized === null ? `
                                    <form action="{{ route('bac.app.destroy', '') }}/${data}" method="POST" 
                                        onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                        data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                ` : ''}
                            @endcan                        
                            @can('app_finalize')
                                ${row.finalized === null ? `
                                    <a class="btn btn-xs btn-warning finalizeIcon" href="{{ route('bac.app.finalize', '') }}/${data}">
                                        {{ trans('global.finalize') }}
                                    </a>
                                ` : ''}
                            @endcan
                            @can('app_revert')
                                ${row.finalized !== null ? `
                                    <a class="btn btn-xs btn-secondary text-white revertIcon" href="{{ route('bac.app.revert', '') }}/${data}">
                                        {{ trans('global.revert') }}
                                    </a>
                                ` : ''}
                            @endcan
                            @can('app_item_access')
                                ${row.category === 'Competitive Bidding' ? `
                                    <a class="btn btn-xs btn-success" href="{{ route('bac.app_item.index2', '') }}/${data}">
                                        {{ 'PPMP-CB' }}
                                    </a>
                                ` : ''}

                                ${row.category === 'CSE' ? `
                                    <a class="btn btn-xs btn-success" href="{{ route('bac.app_cse.index2', '') }}/${data}">
                                        {{ 'PPMP-CSE' }}
                                    </a>
                                ` : ''}

                                ${row.category === 'Non-CSE' ? `
                                    <a class="btn btn-xs btn-success" href="{{ route('bac.app_non_cse.index2', '') }}/${data}">
                                        {{ 'PPMP- Non-CSE' }}
                                    </a>
                                ` : ''}
                            @endcan`;
                    },
                    orderable: false 
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },
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

        // Finalize Data ajax request
        $(document).on('click', '.finalizeIcon', function(e) {        
            e.preventDefault();  
            let url = $(this).attr('href');  // Get the href attribute directly
            let id = url.split('/').pop();  // Extract the ID from the URL
            let csrf = '{{ csrf_token() }}';  // CSRF token
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to finalize this PPMP!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, finalize it!'
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
                                'Finalized!',
                                'Your PPMP has been finalized.',
                                'success'
                            );
                            $('#appTable').DataTable().ajax.reload(null, false);
                        }
                    });
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
                text: "You want to revert the selected PPMP!",
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
                    'Your request for PPMP reversal has been submitted.',
                    'success'
                    )
                    $('#appTable').DataTable().ajax.reload(null, false);
                }
                });
            }
            })
        });    

    });
</script>


@endsection