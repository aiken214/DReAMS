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
                      <a class="btn btn-default" href="{{ route('supply.nod.index2', $data->id) }}">
                          {{ trans('global.back') }} 
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.nod.title_singular') }}
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
                <div class="row">
                    <div style="width: 100%">
                      <img src="{{ asset('image/Letterhead.JPG') }}" class="img-fluid letterhead-print-only" alt="Letterhead" style="display: none; margin: auto;" />               
                    </div>
                </div>    
                
                <div class="row" style="margin:2px 2px 2px 2px; padding:5px 5px 15px 5px">
                    <p style="font-size: 12px;">COA Control No.: ________________________ 
                    <br>Date &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : ________________________</br>
                </div>    

                    <p style="text-align:center; font-size: 20px; margin-bottom:-5px"><b>Notice of Delivery</b></p>
                    <p style="text-align:center; font-size: 12px;"><i>(Submitted to COA within 24 hours from acceptance of deliveries)</i></p>
                

                <div style="margin-bottom:15px">                      
                    <span style="display:inline-block; ">
                      {{-- <p style="font-size: 12px; ">Conformed:</p>                        
                      <p style="font-size: 12px; margin-bottom:-5px; text-align:center">_____________________________________________<br>                  
                                        Signature over Printed Name of Supplier</p> 
                      <p style="font-size: 12px; margin-bottom:-5px; padding-top:10px; text-align:center">______________________________<br>                  
                                        Date</p>   --}}
                    </span>                    
                    <span style="display:inline-block; float:right; width:35%">                         
                      <p style="font-size: 12px; margin-bottom:-1px">P.O./Contract Number: <b>{{ $data->purchase_order?->po_no }}</b></p>                        
                      <p style="font-size: 12px">Date of P.O/Contract: <b>{{ $data->purchase_order?->date }}</b></p>
                    </span>
                </div><br><br>
                <div class="row" style="margin:2px 2px 2px 2px; padding:5px 5px 5px 5px">
                    <p style="font-size: 12px">The Audit Team Leader<br>
                                            <b>{{ strtoupper($auditor->fullname) }}</b><br>
                                                Audit Team Leader</p>
                </div>  
                <div class="row" style="margin:2px 2px 2px 2px; padding:5px 5px 0px 5px">
                    <p style="font-size: 12px;">Sir/Madam: </p>
                </div>

                <div class="row" style="margin:2px 2px 2px 2px; padding:0px 5px 5px 5px">
                    <p style="font-size: 12px; text-indent: 50px">In compliance with paragraph 6.06 of COA Circular No. 95-006 dated May 18, 1995, <b>NOTICE OF DELIVERY</b> of supplies / materials and equipment is hereby served, viz: </p>
                </div>
                <div style="margin:2px 2px 2px 2px; padding:0px 5px 5px 5px">                      
                    <span style="display:inline-block; float-left">
                      <p style="font-size: 12px; text-indent: 50px">Name of Supplier</p>                        
                      <p style="font-size: 12px; text-indent: 50px">P.O/Contract No.</p>                        
                      <p style="font-size: 12px; text-indent: 50px">Total Amount</p>                        
                      <p style="font-size: 12px; text-indent: 50px">Delivery/Invoice Receipt No.</p>                        
                      <p style="font-size: 12px; text-indent: 50px">Date and Time of Inspection</p>                        
                      <p style="font-size: 12px; text-indent: 50px">Place of Delivery</p>                        
                      
                    </span>                    
                    <span style="display:inline-block; float:right; width:70%">                         
                      <p style="font-size: 12px;">: &nbsp;<b>{{ $data->supplier->name }} </b></p>                        
                      <p style="font-size: 12px;">: &nbsp;<b>{{ $data->purchase_order?->po_no }}</b></p>                        
                      <p style="font-size: 12px;">: &nbsp;<b>Php &nbsp;{{ number_format((float)$amount, 2, '.', ',') }}</b></p>                        
                      <p style="font-size: 12px;">: &nbsp;<b>{{ $data->invoice_no }}</b></p>                        
                      <p style="font-size: 12px;">: &nbsp;<b>{{ $data->nod_date }} - {{ \Carbon\Carbon::parse($data->nod_time)->format('h:i A') }}</b></p>                        
                      <p style="font-size: 12px;">: &nbsp;<b>{{ $data->purchase_order?->delivery_place }} </b></p>                        
                      
                    </span>
                </div><br>
                <div style="margin:2px 2px 2px 2px; padding:0px 5px 5px 5px"> 
                    <span style="display:inline-block; float:left"></span>
                    <span style="display:inline-block; float:right; width:50%">                         
                      <p style="font-size: 12px;">Very truly yours,</p>                        
                      <p style="font-size: 12px; text-align: center"><u><b>{{ strtoupper($supply_officer->fullname) }}</b></u></p>                        
                      <p style="font-size: 12px; text-align: center"><i>(Agency Official Responsible for Accepting Deliveries)</i></p>               
                      
                    </span>
                </div><br><br><br><br><br>
                <div style="margin:2px 2px 2px 2px; padding:0px 5px 5px 5px">
                    <p style="font-size: 12px; margin-bottom: -3px">Note:</p>
                    <p style="font-size: 12px; margin-left: 50px">For the Accounting Office, please do not accept Purchase Order (PO), Inspection and Acceptance Report (IAR), Notice of Delivery 
                        and other supporting documents which are not stamped received by COA within the period prescribed per COA Circular Nos. 96-010 dated August 15, 1996 and COA
                        Circular No. 95-006 dated May 18, 1995.</p>
                </div><br>                       
                
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
              var content = document.getElementById(id).innerHTML;

              var html = "<html>";
              html += "<head>";
              html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />";
              html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />";
              html += "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css'>";
              html += "<style>";
              html += "@page { size: A4 portrait; margin: 10mm; }";
              html += "body { margin: 0; }";
              html += "</style>";
              html += "</head>";
              html += "<body>";
              html += `<img src="{{ asset('image/Letterhead.JPG') }}" class="img-fluid" style="display: block; margin: auto;">`; // Add only in print window
              html += content;
              html += "</body>";
              html += "</html>";

              var printWin = window.open('', '_blank');
              printWin.document.write(html);
              printWin.document.close();
              printWin.focus();

              setTimeout(function () {
                  printWin.print();
                  printWin.close();
              }, 250);
          }
      </script>

  @endsection