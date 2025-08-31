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
          @can('request_for_quotation_print')
              <div style="margin-bottom: 10px;" class="row">
                  <div class="col-lg-12">
                      <a class="btn btn-default" href="{{ route('bac.request_for_quotation_item.index2', $data->id) }}">
                          {{ trans('global.back') }} 
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.request_for_quotation.title_singular') }}
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
                <div class="d-flex pb-8" style="padding-bottom: 8px;"><img src="{{url('image/DepEd_Seal.png')}}" alt="" width="75px" height="75px"></div>
                <div class="d-flex oldenglish" style="font-size: 18px"> Republic of the Philippines </div>
                <div class="d-flex oldenglish" style="font-size: 20px"> Department of Education </div>
                <div class="d-flex trajan" style="font-size: 12px; padding-top: 8px; font-weight: 600"> Region XI </div>
                <div class="d-flex trajan" style="font-size: 14px; font-weight: 600"> Schools Division of Davao del Norte </div>
                <h4 style="text-align:center; font-size: 16px; margin-top:20px; "><b>REQUEST FOR QUOTATION</b></h4>
                    <div style="margin-bottom:2px">                      
                        <span style="display:inline-block; ">
                            <p style="font-size: 12px; ">Dealer: ___________________________________________________
                            <br>Address: __________________________________________________</p>
                        </span>
                        
                        <span style="display:inline-block; float:right; ">                         
                            <p style="font-size: 12px;">RFQ No: <b>{{ $data->rfq_no }}</b>
                            </br>Date of Release: <b>{{ $data->date }}</b></p>
                        </span>
                    </div>
                    <div style="display:inline-block; margin-bottom:20px"> 
                        <p style="font-size: 12px; "><b>Notice to the Public</b></p>
                        <p style="font-size: 12px; ">Please quote your lowest price on the item/s listed below, subject to the General Conditions, starting the shortest time of delivery and submit your quotation duly signed by your representative not later than FRIDAY in the return envelope attached herewith.</p>
                    </div>

                    <div style="margin-bottom:10px">                                    
                        <div style="float:right; width:35%">                        
                            <h5 style="font-size: 12px; margin:0px"><b> {{ strtoupper($bac_chair->fullname) }} </b></h5>
                            <p style="font-size: 12px; margin:0px">{{ $bac_chair->position }} <br>
                                                                            BAC Chairman</p>
                        </div>
                    </div><br>
                    <div style="margin-bottom:10px"> 
                        <p style="font-size: 11px; margin:1px">Note:</p>
                        <p style="font-size: 11px; margin:1px; padding-left:30px">1. All entries must be typewritten or legibly written.</p>
                        <p style="font-size: 11px; margin:1px; padding-left:30px">2. Delivery period within {{ $data->delivery_term }} calendar days</p>
                        <p style="font-size: 11px; margin:1px; padding-left:30px">3. Warranty shall be for a period of six (6) months for the supplies materials, one (1) year for equipment</p>
                        <p style="font-size: 11px; margin:1px; padding-left:30px">&nbsp;&nbsp;&nbsp;&nbsp;from date of acceptance by the procuring entity.</p>
                        <p style="font-size: 11px; margin:1px; padding-left:30px">4. Price validity shall be for a period of {{ $data->delivery_term }} calendar days.</p>
                        <p style="font-size: 11px; margin:1px; padding-left:30px">5. {{ $data->requirement }} shall be attached upon submission of the quotation.</p>
                        <p style="font-size: 11px; margin:1px; padding-left:30px">6. Bidders shall submit original brochures showing certification of the product being offered.</p>
                    </div>
                    <div class=" card-body p-0" id="datatable">                        
                        <table class="table table-sm" id="table" cellspacing="0" cellspading="0">
                            <thead>
                                <tr>
                                <!-- <th hidden>ID </th> -->
                                <th width="8%" style="cursor:pointer; text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black">ITEM</th>
                                <th width="10%" style="cursor:pointer; text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black">QUANTITY</th> 
                                <th width="10%" style="cursor:pointer; text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black">UNIT</th>
                                <th width="40%" style="cursor:pointer; text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black">DESCRIPTION</th>
                                <th width="10%" style="cursor:pointer; text-align:center; font-size: 12px; border: 1px solid black">UNIT PRICE (ABC)</th>                                
                                <th width="10%" style="cursor:pointer; text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black">QUOTED PRICE/UNIT</th> 
                                <th width="10%" style="cursor:pointer; text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black">TOTAL AMOUNT</th>                               
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseRequestItems as $purchaseRequestItem)
                                    <tr class="force-page-break" style="font-size: 12px; border: 1px solid black">    
                                        
                                        <td style="text-align:center; border: 1px solid black">{{ $purchaseRequestItem->stock_no }}</td>
                                        <td style="text-align:center; border: 1px solid black">{{ $purchaseRequestItem->quantity }}</td>
                                        <td style="text-align:center; border: 1px solid black">{{ $purchaseRequestItem->unit }}</td>
                                        <td style="text-align:left; border: 1px solid black">{!! nl2br($purchaseRequestItem->description) !!}</td>           
                                        <td style="text-align:center; border: 1px solid black">{{ number_format((float)$purchaseRequestItem->unit_price, 2, '.', ',') }}</td>
                                        <td style="text-align:center; border: 1px solid black"></td>
                                        <td style="text-align:center; border: 1px solid black"></td>

                                    </tr>   
                                @endforeach
                            </tbody>                          
                        </table>
                        
                        <p style="text-align:left; font-size: 12px">Purpose: <b> {{ $data->purchase_request->purpose }}</b></p> 
                        
                    </div>
                    <div style="margin-top:30px">                      
                    
                        <div style="float:right; width:30%">                        
                            <p style="font-size: 12px; margin:0px; text-align:center">____________________________</p>
                            <p style="font-size: 12px; margin:0px; text-align:center">Print Name/Signature</p>
                            <p style="font-size: 12px; margin:0px; padding-top:10px; text-align:center">____________________________</p>
                            <p style="font-size: 12px; margin:0px; text-align:center">Tel. No./Cellphone No.</p>
                            <p style="font-size: 12px; margin:0px; padding-top:10px; text-align:center">____________________________</p>
                            <p style="font-size: 12px; margin:0px; text-align:center">Date</p>
                        </div>
                    </div><br>                                    
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
            printWin.document.write('<html><head><title>Print</title><link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}"></head><body>');
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