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
                      <a class="btn btn-default" href="{{ route('supply.iar.index2', $data->id) }}">
                          {{ trans('global.back') }} 
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.iar.title_short') }}
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
              
              <p style="text-align:right; font-size: 12px;"><i>Appendix 62</i></p>
              <p style="text-align:center; font-size: 20px;"><b>Inspection and Acceptance Report</b></p>
          
              <table style="width: 100%; margin: 0px 15px 0px 15px" cellspacing="0" cellspading="0">                    
                  <tr>
                      <td style="width: 50%">                    
                          <h5 style="text-align: left; font-size: 12px; margin-left: 20px">Entity Name: &nbsp;<b>DepEd Davao del Norte</b></h5>                                                                          
                      </td>
                      <td style="width: 50%"> 
                          <h5 style="text-align: center; font-size: 12px; margin-left: 20px">Fund Cluster: &nbsp;<b>{{ $data->purchase_order?->purchase_request->fund_cluster }}</b></h5>              
                      </td>
                  </tr>
              </table>
              <table style="width: 100%; margin: 0px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                  <tr>
                      <td style="width: 75%; text-align:center; font-size: 12px;  border: 1px solid black">                    
                          
                              <p style="text-align: left; font-size: 12px; margin: 5px 10px 5px 10px">
                                        Supplier: &nbsp;<b>{{ $data->supplier->name }}</b>
                                        @if(!empty($data->purchase_order->po_no)) 
                                          <br>Purchase Order No.: &nbsp;<b>{{ $data->purchase_order->po_no }}</b>
                                          <br>Date: &nbsp;<b>{{ $data->purchase_order->date }} </b>                              
                                        @else
                                          <br>PR No. (Petty Cash): &nbsp;<b>{{ $data->purchase_order?->purchase_request->pr_no }} {{ $data->purchase_request?->pr_no }}</b>
                                          <br>Date: &nbsp;<b>{{ $data->purchase_order?->purchase_request->date }} {{ $data->purchase_request?->date }}</b>     
                                        @endif      
                                        @if(!empty($data->purchase_order?->purchase_request->office))                          
                                          <br>Requisitioning Office/Dept: &nbsp;<b>{{ $data->purchase_order?->purchase_request->office }}</b>                                   
                                          <br>Responsibility Code Center: &nbsp;<b>{{ $data->purchase_order?->purchase_request->res_code }} </b></p>  
                                        @else                    
                                          <br>Requisitioning Office/Dept: &nbsp;<b>{{ $data->purchase_request?->office }}</b>                                   
                                          <br>Responsibility Code Center: &nbsp;<b>{{ $data->purchase_request?->res_code }}</b></p>                                         
                                        @endif
                                                            
                      </td>
                      <td style="width: 25%; text-align:center; font-size: 12px; border: 1px solid black">                    
                          
                              <p style="text-align: left; font-size: 12px; margin: 5px 10px 5px 10px">IAR No.: &nbsp;<b>{{ $data->iar_no }}</b></h5>
                                    <br>IAR Date: &nbsp;<b>{{ $data->date }}</b>                                   
                                    <br>Invoice No.: &nbsp;<b>{{ $data->invoice_no }} </b>                               
                                    <br>Invoice Date: &nbsp;<b>{{ $data->invoice_date }} </b></p>                                                    
                                                  
                      </td>
                  </tr>   
              </table>
              <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0">
                  
                      <tr>
                          <td style="width:20%; height:40px; text-align:center; font-size: 14px; border: 1px solid black"><b>Stock/ Property No.</b></th>
                          <td style="text-align:center; font-size: 14px; border: 1px solid black"><b>Description</b></th>
                          <td style="width:13%; text-align:center; font-size: 14px; border: 1px solid black"><b>Unit</b></th>
                          <td style="width:12%; text-align:center; font-size: 14px; border: 1px solid black"><b>Quantity</b></th>                                 
                      </tr>
                  
                    @foreach ($table_data as $table_datum)
                    <tr>
                        <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->stock_no }}</td>
                        <td style="padding-left: 5px; font-size: 14px; border: 1px solid black">{{ $table_datum->description }}</td>
                        <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->unit }}</td>
                        <td style="text-align:center; font-size: 14px; border: 1px solid black">{{ $table_datum->quantity }}</td>                                   
                    </tr> 
                    @endforeach
                  
              </table>    
              <table style="width: 100%; margin: 10px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                  <tr>
                      <td style="width: 50%; text-align:center; font-size: 12px; border: 1px solid black">                    
                          <i><b>INSPECTION</i></b>                                   
                      </td>
                      <td style="width: 50%; text-align:center; font-size: 12px; border: 1px solid black">                    
                          <i><b>ACCEPTANCE</i></b>                                   
                      </td>
                  </tr>                            
                  <tr>
                      <td width="60%" style="font-size: 12px; border: 1px solid black">                    
                          <p style="margin:10px 10px 10px 10px; font-size: 12px">Date Inspected: ___________________________</p> 
                          <div class="row" style="margin-left:1px">
                              <span><div style="float:left; margin-left:5px; width: 20px; height: 20px; border: 1px solid black"></div>                                   
                              <p style="margin-left: 30px; font-size: 12px">Inspected, verified and found in order as to quantity and specifications</p></span> 
                          </div>                                   
                          <div class="row justify-content-center" style="margin-top: 20px;">
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                <b>{{ strtoupper($inscom_chair->fullname) }}</b>
                                <br>{{ $inscom_chair->position }}/Chairperson
                              </p>                                    
                          </div> 
                          {{-- @foreach($inscom_member as $member) --}}
                          <table style="width: 100%; margin: 10px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                            <tr>
                                <td style="width: 50%; text-align:center; font-size: 12px; padding-top:20px"> 
                                  <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px"><b>{{ isset($inscom_member[0]) ? strtoupper($inscom_member[0]?->fullname) : '' }}</b></p>
                                  <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">{{ isset($inscom_member[0]) ? $inscom_member[0]?->position : '' }}/Member</p> 
                                </td>
                                <td style="width: 50%; text-align:center; font-size: 12px; padding-top:20px"> 
                                  <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px"><b>{{ isset($inscom_member[1]) ? strtoupper($inscom_member[1]?->fullname) : '' }}</b></p>
                                  <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">{{ isset($inscom_member[1]) ? $inscom_member[1]?->position : '' }}/Member</p> 
                                </td>
                            </tr>
                          @if(!empty($inscom_member[3]->fullname))
                            <tr style="padding-top:40px">
                                <td style="width: 50%; text-align:center; font-size: 12px; padding-top:25px"> 
                                    <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px"><b>{{ isset($inscom_member[2]) ? strtoupper($inscom_member[2]?->fullname) : '' }}</b></p>
                                    <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">{{ isset($inscom_member[2]) ? $inscom_member[2]?->position : '' }}/Member</p> 
                                </td>
                                <td style="width: 50%; text-align:center; font-size: 12px; padding-top:25px">
                                    <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px"><b>{{ isset($inscom_member[3]) ? strtoupper($inscom_member[3]?->fullname) : '' }}</b></p>
                                    <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">{{ isset($inscom_member[3]) ? $inscom_member[3]?->position : '' }}/Member</p> 
                                </td>                                              
                            </tr>
                          @else
                            <tr style="padding-top:40px">
                              <td colspan="2" style="text-align:center; font-size: 12px; padding-top:25px"> 
                                <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px"><b>{{ isset($inscom_member[2]) ? strtoupper($inscom_member[2]?->fullname) : '' }}</b></p>
                                <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">{{ isset($inscom_member[2]) ? $inscom_member[2]?->position : '' }}/Member</p>                                    
                              </td>  
                            </tr>
                          @endif
                          </table>
                          <div style="margin-top: 10px; margin-bottom: 10px">
                              <p style="text-align: center; font-size: 12px; margin-top: 10px; padding: 1px"><b>Inspection Officer/Inspection Committee</b></p>                                    
                            </div>
                          {{-- @endforeach --}}
                      <td width="40%" style="font-size: 12px; border: 1px solid black">                    
                          <p style="margin-left: 10px; font-size: 12px">Date Received: ___________________________</p> 
                          <div class="row" style="margin-left:1px">
                              <span><div style="float:left; margin-left: 5px; width: 20px; height: 20px; border: 1px solid black"></div>                                   
                              <p style="margin-left: 30px; font-size: 12px">Complete</p></span>
                          </div>
                          <div class="row" style="margin-left:1px">
                              <span><div style="float:left; margin-left: 5px; width: 20px; height: 20px; border: 1px solid black"></div>                                   
                              <p style="margin-left: 30px; font-size: 12px">Partial (pls. specify quantity)</p></span> 
                          </div>                                    
                          <div class="row justify-content-center" style="margin-top: 135px; margin-bottom: 10px">
                            @if($data->type != "Catering")
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                <b>{{ strtoupper($supply_officer->fullname) }}</b>
                                <br>{{ 'Supply and/or Property Custodian' }}
                              </p>                                    
                            @else
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px"><b>{{ strtoupper($data->purchase_order->purchase_request->requested_by) }}</b></p>
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">{{ $data->purchase_order->purchase_request->designation }}</p> 
                            @endif
                          </div>                                     
                      </td>
                  </tr>
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