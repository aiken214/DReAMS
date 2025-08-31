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
                      <a class="btn btn-default" href="{{ route('supply.ris.index2', $data->id) }}">
                          {{ trans('global.back') }} 
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.ris.title_short') }}
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
                
                <p style="text-align:right; font-size: 12px;"><i>Appendix 63</i></p>                                    
                <p style="text-align:center; font-size: 20px;"><b>Requisition and Issue Slip</b></p>
                
                <table style="width: 100%; margin: 0px 15px 0px 15px" cellspacing="0" cellspading="0">                    
                    <tr>
                        <td style="width: 70%">                    
                            <h5 style="text-align: left; font-size: 12px; margin-left: 10px">Entity Name: &nbsp;<b>Department of Education</b></h5>                                                                          
                        </td>
                        <td style="width: 30%"> 
                          @if(!empty($data->purchase_request->fund_cluster))
                            <h5 style="text-align: center; font-size: 12px; margin-left: 20px">Fund Cluster: &nbsp;<b>{{ $data->purchase_request->fund_cluster }}</b></h5>
                          @else
                            <h5 style="text-align: center; font-size: 12px; margin-left: 20px">Fund Cluster: &nbsp;<b>{{ "01" }}</b></h5>
                          @endif                  
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; margin: 0px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                    <tr>
                        <td style="width: 60%; text-align:center; font-size: 12px;  border: 1px solid black">                    
                            
                                <p style="text-align: left; font-size: 12px; margin: 5px 10px 5px 10px">
                                      Division: &nbsp;<b>{{ "Davao del Norte" }}</b>
                                  <br>Office: &nbsp;<b>{{ $data->office  }}</b>
                                </p>                                    
                                                              
                        </td>
                        <td style="width: 40%; text-align:center; font-size: 12px; border: 1px solid black">                    
                            
                                <p style="text-align: left; font-size: 12px; margin: 5px 10px 5px 10px">
                                      @if(!empty($data->purchase_request->res_code))
                                      Resposibility Code Center: &nbsp;<b>{{ $data->purchase_request->res_code }} </b> 
                                      @else
                                      Resposibility Code Center: 
                                      @endif                                                                
                                      <br>RIS No.: &nbsp;<b>{{ $data->ris_no }} </b> 
                                </p>                                                    
                                                    
                        </td>
                    </tr>   
                </table>
                <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0">

                        <tr>
                          <td colspan = "4" style="width:60%; height:40px; text-align:center; font-size: 14px; border: 1px solid black"><b>Requisition</b></td>
                          <td colspan = "2" style="width:20%; text-align:center; font-size: 14px; border: 1px solid black"><b>Stock Available?</b></td>
                          <td colspan = "2" style="width:20%; text-align:center; font-size: 14px; border: 1px solid black"><b>Issue</b></td>                                                           
                        </tr>
                        <tr>
                            <td style="width:10%; text-align:center; height:40px; font-size: 14px; border: 1px solid black"><b>Stock No.</b></th>
                            <td style="width:8%; text-align:center; font-size: 14px; border: 1px solid black"><b>Unit</b></th>
                            <td style="width:32%; text-align:center; font-size: 14px; border: 1px solid black"><b>Description</b></th>
                            <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Quantity</b></th>                                 
                            <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Yes</b></th>                                 
                            <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>No</b></th>                                 
                            <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Quantity</b></th>                                 
                            <td style="width:10%; text-align:center; font-size: 14px; border: 1px solid black"><b>Remarks</b></th>                                 
                        </tr>
                    
                      @foreach ($table_data as $table_datum)
                      <tr>
                          <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->stock_no }}</td>
                          <td style="text-align:center; padding-left: 5px; font-size: 14px; border: 1px solid black">{{ $table_datum->unit }}</td>
                          <td style="text-align:left; font-size: 14px; border: 1px solid black">{{ $table_datum->description }}</td>
                          <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->issued_quantity }}</td>                                                            
                          <td style="text-align:center; font-size: 14px; border: 1px solid black"> <i class="fas fa-check"></i> </td> 
                          <td style="text-align:center; font-size: 14px; border: 1px solid black"></td>                                
                          <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->issued_quantity }}</td>                                   
                          <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ "Complete" }}</td>                                   
                      </tr> 
                      @endforeach
                    
                </table>    
                <table style="width: 100%; margin: 10px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                    <tr>
                        <td colspan = "8" style="width: 50%; height:50px; text-align:left; padding-left: 5px; font-size: 12px; border: 1px solid black">
                        @if(!empty($data->purchase_request->purpose ))                    
                            <b>Purpose: &nbsp;<b>{{ $data->purchase_request->purpose }}</b>
                        @elseif(!empty($data->donation->purpose )) 
                            <b>Purpose: &nbsp;<b>{{ $data->donation->purpose }}</b>
                        @else
                            <b>Purpose: &nbsp;<b>{{ $data->asset->purpose }}</b>
                        @endif
                        </td>
                    </tr>                            
                    <tr>
                        <td style="width:15%; height:50px; font-size: 12px; border: 1px solid black">Signature:</td> 
                        <td style="width:25%; vertical-align:top; font-size: 12px; padding-left: 5px; border: 1px solid black">Requested by:</td>
                        <td style="width:25%; vertical-align:top; font-size: 12px; border: 1px solid black">Approved by:</td>
                        <td style="width:15%; vertical-align:top; font-size: 12px; border: 1px solid black">Issued by:</td>
                        <td style="width:20%; vertical-align:top; font-size: 12px; border: 1px solid black">Received by:</td>
                    </tr>
                    <tr>
                      <td style="font-size: 12px; border: 1px solid black">Printed Name:</td> 
                      <td style="text-align:center; font-size: 12px; border: 1px solid black">
                        @if(!empty($data->purchase_request->requested_by))
                          <b>{{ strtoupper($data->purchase_request->requested_by) }}</b>
                        @elseif(!empty($data->asset->requester))
                          <b>{{ strtoupper($data->asset?->requester) }}</b>
                        @else
                          <b>{{ strtoupper($data->donation?->requester) }}</b>
                        @endif
                      </td>
                      <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>{{ strtoupper($hope->fullname) }}</b></td>
                      <!-- <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>{{ "EDGAR L. MANARAN" }}</b></td> -->
                      @if(!empty($data->purchase_request->requested_by) && $data->purchase_request->requested_by == $supply_officer->fullname)
                          <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>{{ strtoupper($alt_supply_officer->fullname) }}</b></td>
                      @else
                        <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>{{ strtoupper($supply_officer->fullname) }}</b></td>
                      @endif
                      <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>{{ strtoupper($data->recipient) }}</b></td>
                    </tr>
                    <tr>
                      <td style="font-size: 12px; border: 1px solid black">Designation:</td> 
                      <td style="text-align:center; font-size: 12px; border: 1px solid black">
                        @if(!empty($data->purchase_request->designation))
                          {{ $data->purchase_request->designation }}
                        @elseif(!empty($data->asset->designation))
                          {{ ($data->asset?->designation) }}
                        @else
                          {{ $data->donation?->designation }}
                        @endif
                      <td style="text-align:center; font-size: 12px; border: 1px solid black">Schools Division Superintendent</td>
                      <!-- <td style="text-align:center; font-size: 12px; border: 1px solid black">Education Program Supervisor</td> -->
                      @if(!empty($data->purchase_request->requested_by) && $data->purchase_request->requested_by == $supply_officer->fullname)
                        <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $alt_supply_officer->position }}</td>
                      @else
                        <td style="text-align:center; font-size: 12px; border: 1px solid black">Supply Officer</td>
                      @endif
                      <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->designation }}</td>
                    </tr>
                    <tr>
                      <td style="font-size: 12px; border: 1px solid black">Date:</td> 
                      <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->date }}</td>
                      <td style="text-align:center; font-size: 12px; border: 1px solid black"></td>
                      <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->date }}</td>
                      <td style="text-align:center; font-size: 12px; border: 1px solid black"></td>
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