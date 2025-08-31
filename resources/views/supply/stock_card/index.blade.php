@extends('layouts.user')

@section('content')
@can('stock_card_access')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary" href="{{ route('supply.stock_card_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.stock_card.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ "Stock Card" }} 
    </div>

    <div class="row" style="margin:10px 2px 2px 2px; padding:15px 5px 15px 5px">                      
        <div>
            <p style="margin-bottom:2px;">Item: &nbsp;<b>{{ $item }} </b></p>                                                 
            <p style="margin-bottom:2px;">Description: &nbsp;<b>{{ $description }} </b></p>      
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="stockCardTable">
                <thead>
                    <tr>
                        <th rowspan = "3">
                            {{ trans('cruds.common.fields.id') }}
                        </th>
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.common.fields.date') }}
                        </th>
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.common.fields.reference') }}
                        </th>
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.stock_card.fields.receipt') }} <br> {{ trans('cruds.stock_card.fields.qty') }}
                        </th>
                        <th colspan = "2" style="text-align: center">
                            {{ trans('cruds.stock_card.fields.issue') }}
                        </th>
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.stock_card.fields.balance') }} <br> {{ trans('cruds.stock_card.fields.qty') }}
                        </th>
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.stock_card.fields.no_of_days') }}
                        </th>                        
                    </tr>                    
                    <tr>                                               
                        <th>
                            {{ trans('cruds.stock_card.fields.qty') }}
                        </th>
                        <th style="border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.stock_card.fields.office') }}
                        </th>                      
                    </tr>
                    <tr>        
                        <td>{{ $data->iar->date ?? $data->asset->date ?? $data->donation->date ?? 'N/A' }}</td>
                        <td>{{ $data->iar->iar_no ?? $data->asset->asset_no ?? $data->donation->donation_no ?? 'N/A' }}</td>
                        <td style="text-align: center">{{ $data->receipt_quantity }}</td>
                        <td></td>
                        <td style="text-align: left; padding: 10px">{!! str_replace('/', '/<br>', $office) !!}</td>
                        <td style="text-align: center">{{ $data->receipt_quantity }}</td> 
                        <td></td>
                        
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_stock_card_id" id="hidden_stock_card_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var stock_card_id = $('#hidden_stock_card_id').val();  
    var areYouSureTranslation = @json(trans('global.areYouSure'));

    function addslashes(str) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
    }
</script>

<script>
    $(function () {

        // Configure DataTable defaults
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 3, 'asc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#stockCardTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.stock_card.index') }}?stock_card_id='+stock_card_id, // Your API route
            dom: '<"top"lf>rt<"bottom"ip>',   
            columns: [
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'reference', name: 'reference' },
                { data: 'receipt_quantity', name: 'receipt_quantity' },
                { data: 'issued_quantity', name: 'issued_quantity' },
                { data: 'office', name: 'office' },
                { data: 'balance_quantity', name: 'balance_quantity' },
                { data: 'days_to_consume', name: 'days_to_consume' },
            ],
            columnDefs: [
                { targets: [0], visible: false },
                { className: 'dt-body-center', targets: [4, 6, 7]},
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
        });

    });
</script>


@endsection