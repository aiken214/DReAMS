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
                          {{ trans('global.print') }} {{ trans('cruds.rspi.title_short') }}
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

                <p style="text-align:right; font-size: 12px;"><i>Annex A.7</i></p>                                    
                <p style="text-align:center; font-size: 20px;"><b>Report of Semi-Expendable Property Issued</b></p>

                <table style="width: 100%; margin: 0px 15px 0px 15px" cellspacing="0" cellspading="0">                    
                    <tr>
                        <td style="width: 70%">                    
                            <p style="text-align: left; vertical-align: top; font-size: 12px; margin-left: 5px">Entity Name: &nbsp;<b>{{ 'DepEd Division of Davao del Norte' }}</b>
                            <br>Fund Cluster: &nbsp;<b>{{'  01   '}}</b></p>              
                        </td>
                        <td style="width: 30%"> 
                            <p style="vertical-align: top; font-size: 12px; margin-left: 20px">Serial No.: &nbsp;<b>{{ $serial_no }}</b>
                            <br>Date: &nbsp;<b>{{ $start_date }} - {{ $end_date }}</b></p>              
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0">
                    
                      <tr>
                        <td colspan="6" style="height: 30px; padding-left: 5px; font-size: 12px; border: 1px solid black">To be filled out by the Property and/or Supply Division/Unit</td>
                        <td colspan="2" style="height: 30px; padding-left: 5px; font-size: 12px; border: 1px solid black">To be filled out by the Accounting Division/Unit</td>
                      </tr>
                        <tr>
                            <td style="width:14%; height:40px; text-align:center; font-size: 12px; border: 1px solid black"><b>ICS No.</b></td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Responsibility<br>Center Code</b></td>
                            <td style="width:15%; text-align:center; font-size: 12px; border: 1px solid black"><b>Semi-expendable<br>Property No.</b></td>
                            <td style="text-align:center; width:30%; font-size: 12px; border: 1px solid black"><b>Item Description</b></td>                                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Unit</b></td>                                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Quantity<br>Issued</b></td>                                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Unit<br>Cost</b></td>                                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Amount</b></td>                                 
                        </tr>

                      @foreach ($data as $datum)
                      <tr>
                          <td style="text-align:center; padding-left: 5px; font-size: 12px; border: 1px solid black">{{ $datum->ics_hv_no }}</td>
                          <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ '01' }}</td>   
                          <td style="text-align:center;  font-size: 12px; border: 1px solid black">{{ $datum->ics_item_hv->inventory_item_no }}</td> 
                          <td style=" font-size: 12px; border: 1px solid black">{{ $datum->ics_item_hv->description }}</td> 
                          <td style="text-align:center;  font-size: 12px; border: 1px solid black">{{ $datum->ics_item_hv->quantity }}</td> 
                          <td style="text-align:center; padding-left: 5px; font-size: 14px; border: 1px solid black">{{ $datum->ics_item_hv->unit }}</td>                                                               
                          <td style="text-align:right; padding-right: 3px; font-size: 14px; border: 1px solid black">{{ number_format((float)$datum->ics_item_hv->unit_cost, 2, '.', ',') }}</td>                   
                          <td style="text-align:right; padding-right: 3px; font-size: 14px; border: 1px solid black">{{ number_format((float)$datum->ics_item_hv->total_cost, 2, '.', ',') }}</td>                                                               
                      </tr> 
                      @endforeach
                    
                </table>    
                <table style="width: 100%; margin: 10px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                                      
                    <tr>
                        <td width="60%" style="font-size: 12px; border: 1px solid black">                    
                            <p style="margin:10px 10px 10px 10px; font-size: 12px">I hereby certify to the correctness of the above information.</p> 
                   
                            <div class="row justify-content-center" style="margin-top: 90px;">
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                <b><u>{{ strtoupper($supply_officer->fullname) }}</u></b>
                                <br>Signature over Printed Name <br>Property and/or Supply Custodian                                                                  
                              </p>                                   
                            </div> 
                        </td> 
                        <td width="40%" style="font-size: 12px; border: 1px solid black">                    
                            <p style="margin:10px 10px 10px 10px; font-size: 12px">Posted by:</p>
                            
                            <div class="row justify-content-center" style="margin-top: 90px;">
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                <b><u>{{ strtoupper($accounting_staff->fullname) }}</u></b>
                                <br>Signature over Printed Name <br>Designated Accounting Staff 
                                <br><br><b>_________________</b>
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