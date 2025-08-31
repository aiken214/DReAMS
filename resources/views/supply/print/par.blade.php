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
                          {{ trans('global.print') }} {{ trans('cruds.par.title_short') }}
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

                <p style="text-align:right; font-size: 12px;"><i>Appendix 71</i></p>                                    
                <p style="text-align:center; font-size: 20px;"><b>Property Acknowledgment Receipt</b></p>

                <table style="width: 100%; margin: 0px 15px 0px 15px" cellspacing="0" cellspading="0">                    
                    <tr>
                        <td style="width: 60%">                    
                            <p style="text-align: left; vertical-align: top; font-size: 12px; margin-left: 5px">Entity Name: &nbsp;<b>{{ $data->entity_name }}</b>
                            <br>Fund Cluster: &nbsp;<b>{{ $data->fund_cluster }}</b></p>              
                        </td>
                        <td style="width: 40%"> 
                            <p style="text-align: center; vertical-align: top; font-size: 12px; margin-left: 20px">PAR No.: &nbsp;<b>{{ $data->par_no }}</b></p>              
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0">
                    
                    <tr>
                        <td style="width:10%; height:40px; text-align:center; font-size: 14px; border: 1px solid black"><b>Quantity</b></td>
                        <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Unit</b></td>
                        <td style="width:43%; text-align:center; font-size: 14px; border: 1px solid black"><b>Description</b></td>                                 
                        <td style="width:18%; text-align:center; font-size: 14px; border: 1px solid black"><b>Property Number</b></td>                                 
                        <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Date Acquired</b></td>                                 
                        <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Amount</b></td>                                 
                    </tr> 
                    @foreach ($table_data as $table_datum)                                 
                    <tr>                                    
                          <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->quantity }}</td>
                          <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->unit }}</td>
                          <td style="padding-left: 5px; font-size: 14px; border: 1px solid black">{{ $table_datum->description }}<br>{{ 'S/N: ' }} {{ $table_datum->serial_no }}</td>
                          @php
                            $data1 = $table_datum->property_no; 
                            $data_array = explode(",", $data1); 
                          @endphp 
                            <td style="text-align:center; font-size: 14px; border: 1px solid black">
                              @foreach ($data_array as $element)
                                {{ $element }}<br> 
                              @endforeach 
                            </td>                                 
                          <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->date_acquired }}</td>                                   
                          <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ number_format((float)$table_datum->amount, 2, '.', ',')  }}</td>                                                                 
                    </tr> 
                    @endforeach
                </table>    
                <table style="width: 100%; margin: 10px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                                      
                    <tr>
                        <td width="50%" style="font-size: 12px; border: 1px solid black">                    
                            <p style="margin:10px 10px 10px 10px; font-size: 12px">Received by:</p> 
                            
                            <div class="row justify-content-center" style="margin-top: 90px;">
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                <b><u>{{ strtoupper($supply_officer->fullname) }}</u></b>
                                <br>Signature Over Printed Name                                                         
                                <br><br><b><u>AO IV - Supply Officer</u></b>
                                <br>Position/Office                              
                                <br><b><u>{{ $data->date}}</u></b>
                                <br>Date
                              </p>                                   
                            </div> 
                        </td> 
                        <td width="50%" style="font-size: 12px; border: 1px solid black">                    
                            <p style="margin:10px 10px 10px 10px; font-size: 12px">Issued by:</p> 

                            <div class="row justify-content-center" style="margin-top: 90px;">
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                <b><u>{{ strtoupper($data->recipient) }}</u></b>
                                <br>Signature Over Printed Name                                                         
                                <br><br><b><u>{{ strtoupper($data->designation) }}</u></b>
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