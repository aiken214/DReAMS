@extends('layouts.admin')

@section('content')
@can('employee_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employees.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employee.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Employee', 'route' => 'admin.employees.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employee.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="employeeTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.deped_empid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.lastname') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.firstname') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.middlename') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.ext_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.position') }}
                        </th>
                        <th>
                            {{ trans('cruds.station.fields.station_name') }}
                        </th>
                        <th>
                            &nbsp;
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

$(document).ready( function () {
          fetch_data();
          function fetch_data() { 
            $('#employeeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('api.employee.index') }}', // Your API route
                "pageLength":15,
                "aLengthMenu":[[10,15,25,50,-1],[10,15,25,50,"All"]],
                columns: [
                    // Define your columns based on the data you're receiving
                    { data: null, "defaultContent": "" },
                    { data: 'id', name: 'id' },
                    { data: 'emp_id', name: 'emp_id' },
                    { data: 'lname', name: 'lname' },
                    { data: 'fname', name: 'fname' },
                    { data: 'mname', name: 'mname' },
                    { data: 'ext_name', name: 'ext_name' },
                    { data: 'designation', name: 'designation' },
                    { data: 'office', name: 'office' },
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            return `
                                @can('employee_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employees.show', '') }}/${data}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_edit')
                                    <a class="btn btn-xs btn-info" href="{{ url('admin/employees') }}/${data}/edit">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_delete')                                    
                                    <form action="{{ route('admin.employees.destroy', '') }}/${data}" method="POST" 
                                        onsubmit="return confirm(this.getAttribute('data-confirm') || '{{ addslashes(trans('global.areYouSure')) }}');" 
                                        data-confirm="{{ trans('global.areYouSure') }}" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan`;
                        }
                    },
                ],
                columnDefs:[
                    { className: 'dt-center', targets: [9], orderable: false },
                ]
            });}
        });

    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('employee_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employees.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 3, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Employee:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection