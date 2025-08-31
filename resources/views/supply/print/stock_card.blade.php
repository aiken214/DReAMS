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
                      <a class="btn btn-default" href="{{ route('supply.stock_card.index2', $data->id) }}">
                          {{ trans('global.back') }} 
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.stock_card.title_singular') }}
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

                    <p style="text-align:right; font-size: 12px;"><i>Appendix 58</i></p>                                    
                    <p style="text-align:center; font-size: 20px;"><b>Stock Card</b></p>

                    <table style="width: 100%; margin: 0px 15px 0px 15px" cellspacing="0" cellspading="0">                    
                        <tr>
                            <td style="width: 50%">                    
                                <h5 style="text-align: left; font-size: 12px; margin-left: 20px">Entity Name: &nbsp;<b>DepEd Division of Davao del Norte</b></h5>                                                                          
                            </td>
                            <td style="width: 50%">                                       
                                <h5 style="text-align: center; font-size: 12px; margin-left: 20px">Fund Cluster: &nbsp;<b>{{ '01' }}</b></h5>
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%; margin: 0px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                        <tr>
                            <td style="width: 60%; text-align:center; font-size: 12px;  border: 1px solid black">                    
                                
                                    <p style="text-align: left; font-size: 12px; margin: 5px 10px 5px 10px">
                                          Item: &nbsp;<b>{{ $item }}</b>
                                      <br>Description: &nbsp;<b>{{ $description  }}</b>
                                      <br>Unit of Measurement: &nbsp;<b>{{ $data->unit  }}</b>
                                    </p>                                    
                                                                  
                            </td>
                            <td style="width: 40%; text-align:center; font-size: 12px; border: 1px solid black">                    
                                
                                    <p style="text-align: left; font-size: 12px; margin: 5px 10px 5px 10px">                                                  
                                          Stock No.: &nbsp;<b>{{ $data->stock_no }} </b>                                                                                                            
                                          <br>Re-order Point: &nbsp;<b> </b> 
                                    </p>                                                    
                                                        
                            </td>
                        </tr>   
                    </table>
                    <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0">
                            
                        <tr>
                            <td rowspan = "2" style="width:10%; text-align:center; height:40px; font-size: 12px; border: 1px solid black"><b>Date</b></td>
                            <td rowspan = "2" style="width:16%; text-align:center; font-size: 12px; border: 1px solid black"><b>Reference</b></td>
                            <td rowspan = "2" style="width:8%; text-align:center; font-size: 12px; border: 1px solid black"><b>Receipt Qty</b></td>
                            <td colspan = "2" style="width:44%; text-align:center; font-size: 12px; border: 1px solid black"><b>Issue</b></td>                                 
                            <td rowspan = "2" style="width:8%; text-align:center; font-size: 12px; border: 1px solid black"><b>Balance Qty</b></td>                                 
                            <td rowspan = "2" style="width:14%; text-align:center; font-size: 12px; border: 1px solid black"><b>No. of Days to Consume</b></td>                 
                        </tr>
                        <tr>
                            <td style="width:6%; text-align:center; text-align:center; font-size: 12px; border: 1px solid black"><b>Qty</b></td>
                            <td style="width:44%; text-align:center; font-size: 12px; border: 1px solid black"><b>Office</b></td>                 
                        </tr>
                        <tr>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->iar->date ?? $data->asset->date ?? $data->donation->date ?? 'N/A' }}</td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->iar->iar_no ?? $data->asset->asset_no ?? $data->donation->donation_no ?? 'N/A' }} </td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->receipt_quantity }}</td>
                            <td style="text-align:center; padding-left: 5px; font-size: 12px; border: 1px solid black"> </td>                                 
                            <td style="text-align:left; font-size: 12px; padding: 5px; border: 1px solid black">{!! str_replace('/', '/<br>', $office) !!}</td>                                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->receipt_quantity }}</th>                 
                            <td style="text-align:center; padding-left: 5px; font-size: 12px; border: 1px solid black"></td>
                        </tr>
                        @foreach ($table_data as $table_datum)
                        <tr>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum->ris->date }}</td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum->ris->ris_no }}</td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"> </td>
                            @php
                              $balance_quantity = $table_datum->balance_quantity -  $table_datum->issued_quantity;
                            @endphp
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum->issued_quantity }} </td>
                            <td style="text-align:left; padding-left: 5px; font-size: 12px; border: 1px solid black">{{ $table_datum->ris->office }}/ <br> {{ $table_datum->ris->recipient }}</td>                                   
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $balance_quantity}}</td>
                            <td style="text-align:center; padding-left: 5px; font-size: 12px; border: 1px solid black"></td>                                 
                        </tr> 
                        @endforeach                               
                    </table>                             
                  </div>                                                             
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