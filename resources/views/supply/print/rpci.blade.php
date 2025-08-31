@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    
@endsection

@section('content')

  <!-- Main content -->
  <section class="content">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        @can('ppmp_print')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-default" href="{{ URL::previous() }}">
                        {{ trans('global.back') }} 
                    </a>
                    <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                        {{ trans('global.print') }} {{ trans('cruds.rpci.title_short') }}
                    </a>
                </div>
            </div>
        @endcan
          <div class="col-lg-12" style="margin-top: 20px;">
            
              <style type="text/css" media="print">
        
                @page{
                  size: auto;
                  margin: 0mm;
                }       
        
                @media print{
                  .page-break {
                    page-break-after: always;
                  }
                  img{
                    -webkit-print-color-adjust: exact;
                  }                            
                }
        
              </style>    

                  
            <div id="test"> 
                    
              <p style="text-align:right; font-size: 12px;"><i>Appendix 66</i></p>                                    
              <p style="text-align:center; font-size: 20px; bottom-margin: 30px;"><b>REPORT ON THE PHYSICAL COUNT OF INVENTORIES</b></p>
                                   
              @isset($type)
                <p style="text-align:center; font-size: 16px; margin-bottom: 0px; padding-bottom: 0px;"><b>{{ $type }}</b></p>
                <p style="text-align:center; margin-top: 0px; padding-top: 0px; margin-bottom: 0px; padding-bottom: 0px; font-size: 10px;">(Type of Inventory Item)</p>
              @endisset
              <p style="text-align:center; margin-top: 0px; padding-top: 0px; font-size: 12px;">As at <u><b>{{ $asOf }}</b></u></p>

              <div class="my_text">
                  <p style="font-size: 12px; ">Fund Cluster: <b><u>    01    </u></b>
                  <br>For which &nbsp;&nbsp;<b><u> {{ $hope->fullname }} </u></b>, &nbsp;&nbsp;<b><u>{{ $hope->position }}</u></b>, &nbsp;&nbsp;<b><u>{{ ucwords(strtolower($hope->station?->station_name)) }}</u></b> is accountable, having assumed such accountability on <b><u>{{ \Carbon\Carbon::parse($hope->date_assumption)->format('F j, Y') }}</u></b>.</br>
              </div>

              <div class=" card-body p-0" id="datatable">
                                        
                <table class="border table table-sm" id="table" style="font-size: 12px; text-align:center; vertical-align:middle">
                    <thead>
                        <tr>
                            <th rowspan='2' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.rpci.fields.article') }}
                            </th>
                            <th rowspan='2' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.rpci.fields.description') }}
                            </th>
                            <th rowspan='2' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.rpci.fields.stock_no') }}
                            </th>
                            <th rowspan='2' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.rpci.fields.unit') }}
                            </th>
                            <th rowspan='2' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.rpci.fields.unit_value') }}
                            </th>
                            <th rowspan='1' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ 'Balance Per' }} <br> {{ 'Card' }}
                            </th>
                            <th rowspan='1' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ 'On Hand Per' }} <br> {{ 'Count' }}
                            </th>
                            <th colspan='2' style="vertical-align:middle; text-align:center; border: 1px solid #000000;">
                                {{ __('Shortage/Overage') }}
                            </th>
                            <th rowspan='2' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.rpci.fields.remarks') }}
                            </th>
                        </tr>
                        <tr> 
                            <th style="text-align:center; border: 1px solid #000000;">
                                {{ 'Quantity' }}
                            </th>
                            <th style="text-align:center; border: 1px solid #000000;">
                                {{ 'Quantity' }} 
                            </th>                       
                            <th style="text-align:center; border: 1px solid #000000;">
                                {{ trans('cruds.rpci.fields.quantity_so') }}
                            </th>
                            <th style="text-align:center; border: 1px solid #000000;">
                                {{ trans('cruds.rpci.fields.value_so') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($items as $data)
                        <tr>
                            <td style="border: 1px solid black">{{ $data->article }}</td>
                            <td style="border: 1px solid black; text-align:left">{!! nl2br($data->description) !!}</td>
                            <td style="border: 1px solid black">{{ $data->stock_no }}</td>
                            <td style="border: 1px solid black">{{ $data->unit }}</td>
                            <td class="pr-3" style="border: 1px solid black; text-align:right">{{ number_format((float)$data->unit_value, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black">{{ $data->quantity_property_card }}</td>
                            <td style="border: 1px solid black">{{ $data->quantity_physical_count }}</td>
                            <td style="border: 1px solid black">{{ $data->quantity_so }}</td>                           
                            <td class="pr-3" style="border: 1px solid black; text-align:right">{{ number_format((float)$data->value_so, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black">{{ $data->remarks }}</td>                                                          
                        </tr>   
                      @endforeach                      
                    </tbody>                       
                      <tr>                        
                          <td colspan="4" style="text-align:center; border: 1px solid #000000;">
                              {{ 'Total' }}
                          </td>
                          <td class="pr-3" style="border: 1px solid #000000; text-align:right;">
                              ₱{{ number_format($totalCost, 2) }}
                          </td>
                          <td colspan="5" style="text-align:center; border: 1px solid #000000;">
                              {{ '' }}
                          </td>
                      </tr>                                      
                </table>
                <br>
                <div class="row">
                    <div class="column" style="width:30%; text-align: center;">
                      <p style="text-align: left; font-size: 12px; margin-bottom: 40px;">Certified Correct By:</p>
                      <p style="font-size: 12px;"><b><u>{{ strtoupper($supply_officer->fullname) }}</u></b><br>
                      {{ $supply_officer->position }}</p>
                    </div>
                    <div class="column" style="width:30%; text-align: center;">
                    <p style="text-align: left; font-size: 12px; margin-bottom: 40px;">Approved By:</p>
                      <p style="font-size: 12px;"> <b><u>{{ strtoupper($hope->fullname) }}</u></b><br>
                      {{ $hope->position }}</p>
                    </div>
                    <div class="column" style="width:30%; text-align: center;">
                    <p style="text-align: left; font-size: 12px; margin-bottom: 40px;">Verified By:</p>
                        <p style="font-size: 12px;"><b><u>{{ strtoupper($auditor->fullname) }}</u></b><br>
                        {{ $auditor->designation }}</p>
                    </div>
                </div>         
              </div>                                
            </div>
          </div>
        </div>
      </div> 
    </div>
  </section>
  
  @endsection 

  @section('scripts')
      <script>
        function printPage(id) {
            var html = "<html>";
            html += "<head>";
            html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />";
            html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />";
            html += "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css'>";
            html += "<style>";
            html += "@page { size: A4 landscape; margin: 10mm; }"; // Set A4 landscape
            html += "body { margin: 0; }"; // Ensure the body has no margin
            html += "</style>";
            html += "</head>";
            html += "<body>";
            html += document.getElementById(id).innerHTML;
            html += "</body>";
            html += "</html>";

            

            var printWin = window.open();
            printWin.document.write(html);
            printWin.document.close(); // Ensure the document is fully loaded before further execution
            printWin.focus();

            setTimeout(function() {
            printWin.print();
            printWin.close();
            }, 250);
        }

        function Export(id) {
            window.alert("File successfully exported!");
            $("#test").table2excel({
            filename: "Training_Certificate.xlsx"
            });
        }
      </script>
  @endsection