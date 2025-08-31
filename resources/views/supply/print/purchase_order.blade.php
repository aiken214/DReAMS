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
                      <a class="btn btn-default" href="{{ route('supply.purchase_order_item_check.index2', $data->id) }}">
                          {{ trans('global.back') }} 
                      </a>
                      <!-- <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.purchase_order.title_singular') }}
                      </a> -->
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
              <div style="margin-bottom:16px">
                    <div style="text-align: right; padding: 0 5px; margin: 0 10px;">
                      <p style="font-size: 12px; margin: 0;">
                        <i>Appendix 61</i>
                      </p>
                    </div>
                    <div style="width: 100%">
                      <img src="{{ asset('image/Letterhead.JPG') }}"  class="img-fluid" alt="Letterhead" style="display: block; margin: auto;" hidden>
                    </div>   
                        <div style="margin-bottom:6px">
                          <h4 style="text-align:center; font-size: 16px; margin-top:10px; "><b>PURCHASE ORDER</b></h4>
                        </div>
                        <div style="margin-bottom:px">                      
                          <span style="display:inline-block; float:left; width:70%">

                              <p style="font-size: 12px">Supplier: &nbsp;<b>{{ $data->supplier->name }}</b><br>
                                  Address: &nbsp; <b>{{ $data->supplier->address }}</b><br>
                                  TIN: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>{{ $data->supplier->tin }}</b><br>
                                  P.R. No. / Date: &nbsp;<b>{{ $data->purchase_request->pr_no }} / {{ $data->date }}</b></p>
                          </span>                    
                          <span style="display:inline-block; float:right; width:30%">                         
                              <p style="font-size: 12px">P.O. No: &nbsp;<b>{{ $data->po_no }}</b><br>
                                  Date: &nbsp;<b>{{ $data->date }}</b><br>
                                  Mode of Procurement: &nbsp;<b>{{ $data->mode }}</b></p>
                          </span>
                        </div>
                        <div style="margin-bottom:3px">                      
                          <span style="display:inline-block; ">
                            <h3 style="font-size: 12px">Gentlemen:</h3>
                            <p style="font-size: 12px; ">Please furnish this Office the following articles subject to the terms and conditions contained herein:</p>
                          </span>                    
                          <span style="display:inline-block; float:right; ">                         
                              
                          </span>
                        </div>
                        <div style="margin-bottom:10px">                      
                          <span style="display:inline-block; ">
                            <p style="font-size: 12px">Place of Delivery: &nbsp;<b>{{ $data->delivery_place }}</b><br>
                                  Date of Delivery: &nbsp;<b>{{ $data->delivery_date ?? 'On the date' }}</b></p>
                          </span>                    
                          <span style="display:inline-block; float:right; width:30%">                         
                              <p style="font-size: 12px">Delivery Term: &nbsp;<b>{{ $data->delivery_term }} days</b><br>
                                  Payment Term: &nbsp;<b>{{ $data->payment_term }}</b></p>
                          </span>
                        </div>
                        
                      <div id="datatable">                        
                          <table class="table table-sm" id="table" style="font-size: 11px; text-align:center; vertical-align:middle">
                              <thead>
                                  <tr>
                                    <th width="8%" style="cursor:pointer; text-align:center; border: 1px solid black">STOCK/ <br>PROPERTY NO.</th>
                                    <th width="10%"style="cursor:pointer; text-align:center; border: 1px solid black">UNIT</th> 
                                    <th width="30%" style="cursor:pointer; text-align:center; border: 1px solid black">DESCRIPTION</th>
                                    <th width="10%" style="cursor:pointer; text-align:center; border: 1px solid black">QUANTITY</th>
                                    <th width="10%" style="cursor:pointer; text-align:center; border: 1px solid black">UNIT COST</th>                                
                                    <th width="10%" style="cursor:pointer; text-align:center; border: 1px solid black">AMOUNT</th>                        
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($items as $item)
                                  <tr>            
                                    <td style="text-align:center; border: 1px solid black; vertical-align: middle">{{ $item->stock_no }}</td>
                                    <td style="text-align:center; border: 1px solid black; vertical-align: middle">{{ $item->unit }}</td>
                                    <td style="padding-left:10px; text-align:left; border: 1px solid black; vertical-align: middle">{!! nl2br($item->description) !!}</td> 
                                    <td style="text-align:center; border: 1px solid black; vertical-align: middle">{{ $item->quantity }}</td>                       
                                    <td style="text-align:right; border: 1px solid black; padding-right: 5px; vertical-align: middle">{{ number_format((float)$item->unit_cost, 2, '.', ',') }}</td>
                                    <td style="text-align:right; border: 1px solid black; padding-right: 5px; vertical-align: middle">{{ number_format((float)$item->amount, 2, '.', ',') }}</td>                                  
                                  <tr>
                                @endforeach
                                <tr>
                                  <td colspan="1" style="border: 1px solid black; vertical-align: middle"> 
                                      <p style="text-align:left; font-size: 10px">(Total Amount in Words) </p>                                     
                                  </td>
                                  <td colspan="3" style="border: 1px solid black; vertical-align: middle"> 
                                      <p style="text-align:left; padding-left:3px; font-size: 12px;">  
                                      <?php                                    
                                          $cost = number_format($totalCost,2,".",""); 
                                          $num_arr = explode(".",$cost); 
                                          $wholenum = $num_arr[0]; 
                                          $decnum = $num_arr[1];                                       
                      
                                          $whole = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                          $w = strtoupper($whole->format($wholenum)). " PESOS";
                                        
                                          if($decnum != 0){
                                          $dec = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                          $d = strtoupper($dec->format($decnum)). " CENTAVOS";
                                          $word = $w. " AND " . $d;
                                          }else{
                                          $word = $w;
                                          }                                      
                                          echo $word;                                  
                                      ?></p>                                     
                                  </td>
                                  <td colspan="1" style="border: 1px solid black; padding-right: 5px; vertical-align: middle">                    
                                      <p style="text-align:right; font-size: 12px">Total Cost </p>                                     
                                  </td>
                                  <td colspan="1" style="text-align:right; border: 1px solid black; padding-right: 5px; vertical-align: middle">                    
                                      <p style="float-right; font-size: 12px"><b>@php echo number_format($totalCost,2,".",",") @endphp</b></p>                                     
                                  </td>
                                </tr>  
                              </tbody>                              
                          </table>                      
                      </div>
                    
                      <div style="margin-bottom:10px; margin-top:5px">                     
                        <p style="font-size: 12px; margin-bottom:-5px">Purpose: <b>{{$data->purchase_request->purpose}}</b></p>
                        <p style="font-size: 12px; ">Source of Fund: <b>{{$data->purchase_request->fund_source}}<b></p>
                      </div>

                      <div style="margin-bottom: 15px">
                        <span style="display: inline-block;">
                          <p style="font-size: 12px; font-weight: normal;">Conformed:</p>
                          <p style="font-size: 12px; margin-bottom: -5px; text-align: center; font-weight: normal;">
                            _____________________________________________<br>
                            Signature over Printed Name of Supplier
                          </p>
                          <p style="font-size: 12px; margin-bottom: -5px; padding-top: 10px; text-align: center; font-weight: normal;">
                            ______________________________<br>
                            Date
                          </p>
                        </span>
                        <span style="display: inline-block; float: right; width: 40%;">
                          <p style="font-size: 12px; margin-bottom: 20px; font-weight: normal;">Very truly yours,</p>
                          <p style="font-size: 12px; text-align: center; margin-bottom: -5px; font-weight: normal;">
                            <b><u>{{ strtoupper($hope->fullname) }}</u></b><br>
                            {{$hope->position}}
                          </p>
                        </span>
                      </div>
                      <div style="border: 1px solid black; margin-bottom: 15px">
                        <span style="padding-left: 10px; display: inline-block;">
                          <p style="font-size: 12px; font-weight: normal;">Fund Cluster: ____________________________________<br>
                            Funds Available: _________________________________</p>
                          <p style="font-size: 12px; margin-bottom: 5px; padding-top: 20px; text-align: center; font-weight: normal;">
                            <b><u>{{ strtoupper($accountant->fullname) }}</u></b><br>
                            {{ strtoupper($accountant->position) }}
                          </p>
                        </span>
                        <span style="display: inline-block; float: right; width: 40%;">
                          <p style="font-size: 12px; margin-bottom: -5px; font-weight: normal;">ORS/BURS No.: _____________________________<br>
                            Date of the ORS/BURS: _____________________<br>
                            Amount: _______________________________</p>
                        </span>
                      </div>
              </div>
            </div><br>
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