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
          @can('purchase_order_item_check_access')
              <div style="margin-bottom: 10px;" class="row">
                  <div class="col-lg-12">
                      <a class="btn btn-default" href="{{ URL::previous() }}">
                        {{ trans('global.back') }}
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.ics.title_short') }}
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
                
                <p style="text-align:right; font-size: 12px;"><i>Appendix 59</i></p>                                    
                <p style="text-align:center; font-size: 20px;"><b>Inventory Custodian Slip ({{$title_value}})</b></p>

                <table style="width: 100%; margin: 0px 15px 0px 15px" cellspacing="0" cellspading="0">                    
                    <tr>
                        <td style="width: 60%">                    
                            <p style="text-align: left; vertical-align: top; font-size: 12px; margin-left: 5px">Entity Name: &nbsp;<b>{{ optional($table_data->first())->entity_name ?? 'N/A' }}</b>
                            <br>Fund Cluster: &nbsp;<b>{{ optional($table_data->first())->fund_cluster ?? 'N/A' }}</b></p>              
                        </td>
                        <td style="width: 40%"> 
                            <p style="text-align: center; vertical-align: top; font-size: 12px; margin-left: 20px">Reference: &nbsp;<b>{{ optional($table_data->first())->ris->ris_no ?? 'N/A' }}</b></p>              
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0">
                    
                        <tr>
                            <td rowspan = "2" style="width:10%; height:40px; text-align:center; font-size: 14px; border: 1px solid black"><b>ICS No.</b></td>
                            <td rowspan = "2" style="width:10%; height:40px; text-align:center; font-size: 14px; border: 1px solid black"><b>Quantity</b></td>
                            <td rowspan = "2" style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Unit</b></td>
                            <td colspan = "2" style="width:20%; text-align:center; font-size: 14px; border: 1px solid black"><b>Amount</b></td>
                            <td rowspan = "2" style="width:37%; text-align:center; font-size: 14px; border: 1px solid black"><b>Description</b></td>                                 
                            <td rowspan = "2" style="width:13%; text-align:center; font-size: 14px; border: 1px solid black"><b>Inventory Item No.</b></td>                                 
                            <td rowspan = "2" style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Estimated Useful Life</b></td>                                 
                        </tr>
                        <tr>                                       
                            <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Unit Cost</b></th>
                            <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Total Cost</b></td>
                        </tr>
                    
                        @foreach ($table_data as $table_datum)
                        <tr>
                            <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->ics_hv_no }}</td>
                            <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->ics_item_hv->quantity }}</td>
                            <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->ics_item_hv->unit }}</td>
                            <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ number_format((float) str_replace(',', '', $table_datum->ics_item_hv->unit_cost), 2, '.', ',') }}</td> 
                            <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ number_format((float) str_replace(',', '', $table_datum->ics_item_hv->total_cost), 2, '.', ',') }}</td>                                   
                            <td style="padding-left: 5px; font-size: 14px; border: 1px solid black">{!! nl2br($table_datum->ics_item_hv->description) !!}<br>{{ 'S/N: ' }} {{ $table_datum->ics_item_hv->serial_no }}</td>                                                                                                    
                            @php
                              $data1 = $table_datum->ics_item_hv->inventory_item_no; 
                              $data_array = explode(",", $data1); 
                            @endphp  
                              <td style="text-align:center; font-size: 14px; border: 1px solid black">
                                @foreach ($data_array as $element)
                                  {{ $element }}<br> 
                                @endforeach 
                              </td>
                            <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->ics_item_hv->lifespan }}</td>                                   
                        </tr> 
                        @endforeach
                        <tr>
                            <td colspan="5" style="font-size: 12px; border: 1px solid black">                    
                                <p style="margin:10px 10px 10px 10px; font-size: 12px">Received from:</p>
                                <div class="row justify-content-center" style="margin-top: 90px;">
                                  <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                    <b><u>{{ strtoupper($supply_officer->fullname) }}</u></b>
                                    <br>Signature Over Printed Name                                                         
                                    <br><br><b><u>AO IV - Supply Officer</u></b>
                                    <br>Position/Office                              
                                    <br><b><u>{{ optional($table_data->first())->date ?? 'N/A' }}</u></b>
                                    <br>Date
                                  </p>                                   
                                </div> 
                            </td> 
                            <td colspan="3" style="font-size: 12px; border: 1px solid black">                    
                                <p style="margin:10px 10px 10px 10px; font-size: 12px">Received by:</p>                                                                      
                                <div class="row justify-content-center" style="margin-top: 90px;">
                                  <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                    <b><u>{{ strtoupper(optional($table_data->first())->recipient ?? 'N/A') }}</u></b>
                                    <br>Signature Over Printed Name                                                         
                                    <br><br><b><u>{{ strtoupper(optional($table_data->first())->designation ?? 'N/A') }}</u></b>
                                    <br>Position/Office                              
                                    <br><b>_________________</b>
                                    <br>Date
                                  </p>                                   
                                </div> 
                            </td>
                        </tr>
                </table> 
              </div>                                   
          </div>
        </div>
      </div> 
    </div>
  </section>
  
  @endsection 

  @section('scripts')
      <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
      
      <script>
        function printPage(id) {
            var html = "<html>";
            html += "<head>";
            html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />";
            html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />";
            html += "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css'>";
            html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>";
            html += "<style>";
            html += "@page { size: A4 portrait; margin: 10mm; }"; // Set A4 portrait
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