@extends('layouts.user')

@section('content')
@can('stock_card_access')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-secondary" href="{{ route('supply.property_card_print', $id) }}">
                {{ trans('global.view') }} {{ trans('cruds.property_card.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.property_card.title_singular') }}
    </div>

    <div class="row" style="margin:10px 2px 2px 2px; padding:15px 5px 15px 5px">                      
        <div>
            <p style="margin-bottom:2px;">Item: &nbsp;<b>{{ $item }} </b></p>                                                 
            <p style="margin-bottom:2px;">Description: &nbsp;<b>{{ $description }} </b></p>      
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="propertyCardTable">
                <thead>
                    <tr>
                        <th rowspan = "2">
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
                            {{ trans('cruds.common.fields.amount') }}
                        </th>   
                        <th rowspan = "2" style="vertical-align: middle">
                            {{ trans('cruds.common.fields.remarks') }}
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
                        <td></td>    
                        <td>{{ $data->iar->date ?? $data->asset->date ?? $data->donation->date ?? 'N/A' }}</td>
                        <td>{{ $data->iar->iar_no ?? $data->asset->asset_no ?? $data->donation->donation_no ?? 'N/A' }}</td>
                        <td style="text-align: center">{{ $data->receipt_quantity }}</td>
                        <td></td>
                        <td style="text-align: left">{{ $office }}</td>
                        <td style="text-align: center">{{ $data->receipt_quantity }}</td> 
                        <td style="text-align: right">{{ number_format((float)$amount, 2, '.', ',') }}</td> 
                        <td></td>                        
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="hidden_property_card_id" id="hidden_property_card_id" value="{{ $id }}"/>   
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent

<script>
    var property_card_id = $('#hidden_property_card_id').val();  
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
        let table = $('#propertyCardTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('api.property_card.index') }}?property_card_id='+property_card_id, // Your API route
            dom: '<"top"lf>rt<"bottom"ip>',   
            columns: [
                { data: 'id', name: 'id' },
                { data: 'date', name: 'date' },
                { data: 'reference', name: 'reference' },
                { data: 'receipt_quantity', name: 'receipt_quantity' },
                { data: 'issued_quantity', name: 'issued_quantity' },
                { data: 'office', name: 'office' },
                { data: 'balance_quantity', name: 'balance_quantity' },
                { data: 'amount', name: 'amount', render: $.fn.dataTable.render.number(',', '.', 2) },
                { data: 'remarks', name: 'remarks' },
            ],
            columnDefs: [
                { targets: [0], visible: false },
                { className: 'dt-body-center', targets: [4, 6]},
                { className: 'dt-body-right', targets: [7]},
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
        });

    });
</script>


@endsection