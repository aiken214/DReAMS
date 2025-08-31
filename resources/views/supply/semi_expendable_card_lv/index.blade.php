@extends('layouts.user')

@section('content')
@can('stock_card_access')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary" href="{{ route('supply.semi_expendable_card_lv_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.semi_expendable_card.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.semi_expendable.title_singular') }}
    </div>

    <div class="row" style="margin:10px 2px 2px 2px; padding:15px 5px 15px 5px">                      
        <div>
            <p style="margin-bottom:2px;">Item: &nbsp;<b>{{ $item }} </b></p>                                                 
            <p style="margin-bottom:2px;">Description: &nbsp;<b>{{ $description }} </b></p>      
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="semiExpendableCardTable">
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
                        <th colspan = "3" style="text-align: center">
                            {{ trans('cruds.stock_card.fields.receipt') }}
                        </th>
                        <th colspan = "3" style="text-align: center">
                            {{ 'Issue/Transfer/Disposal' }}
                        </th>
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.stock_card.fields.balance') }} <br> {{ trans('cruds.stock_card.fields.qty') }}
                        </th>
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.common.fields.amount') }}
                        </th>  
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.common.fields.remarks') }}
                        </th>                        
                    </tr>                    
                    <tr>                                               
                        <th>
                            {{ trans('cruds.common.fields.qty') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.unit_cost') }}
                        </th>
                        <th style="border-right: 1px solid #D3D3D3;">
                            {{ trans('cruds.common.fields.total_cost') }}
                        </th>
                        
                        <th>
                            {{ trans('cruds.common.fields.item_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.common.fields.qty') }}
                        </th>
                        <th style="border-right: 1px solid #D3D3D3;">
                            {{ 'Office/Officer' }}
                        </th>   
                    </tr>
                    <tr>        
                        <td>{{ $data->iar->date ?? $data->asset->date ?? $data->donation->date ?? 'N/A' }}</td>
                        <td>{{ $data->iar->iar_no ?? $data->asset->asset_no ?? $data->donation->donation_no ?? 'N/A' }}</td>
                        <td style="text-align: center">{{ $data->receipt_quantity }}</td>
                        <td style="text-align: right">{{ number_format((float)$unit_price, 2, '.', ',') }}</td>
                        <td style="text-align: right">{{ number_format((float)$amount, 2, '.', ',') }}</td>
                        <td style="text-align: center">{{ $data->stock_no }}</td>
                        <td></td>                        
                        <td style="text-align: left; padding: 10px">{!! str_replace('/', '/<br>', $office) !!}</td>
                        <td style="text-align: center">{{ $data->receipt_quantity }}</td> 
                        <td style="text-align: right">{{ number_format((float)$amount, 2, '.', ',') }}</td> 
                        <td style="text-align: right">{{ $data->remarks }}</td> 
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_semi_expendable_card_id" id="hidden_semi_expendable_card_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var semi_expendable_card_id = $('#hidden_semi_expendable_card_id').val();  
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
            order: [[ 2, 'asc' ]], // Adjust sorting to match server-side columns
            pageLength: 15, // Changed to match your requirement
            aLengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
        });

        // Initialize DataTable with server-side processing
        let table = $('#semiExpendableCardTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.semi_expendable_card_hv.index') }}?semi_expendable_card_id='+semi_expendable_card_id, // Your API route
            dom: '<"top"lf>rt<"bottom"ip>',   
            columns: [
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'reference', name: 'reference' },
                { data: 'receipt_quantity', name: 'receipt_quantity' },
                { data: 'unit_cost', name: 'unit_cost' },
                { data: 'total_cost', name: 'total_cost' },
                { data: 'stock_no', name: 'stock_no' },
                { data: 'issued_quantity', name: 'issued_quantity' },
                { data: 'office', name: 'office' },
                { data: 'balance_quantity', name: 'balance_quantity' },
                { data: 'amount', name: 'amount' },
                { data: 'remarks', name: 'remarks' },
            ],
            columnDefs: [
                { targets: [0], visible: false },
                { className: 'dt-body-center', targets: [3, 7, 9]},
                { className: 'dt-body-right', targets: [4, 5, 10]},
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
        });

    });
</script>


@endsection