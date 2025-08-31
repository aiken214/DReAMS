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
          @can('purchase_request_print')
              <div style="margin-bottom: 10px;" class="row">
                  <div class="col-lg-12">
                      <a class="btn btn-default" href="{{ route('user.purchase_request_item.index2', $data->id) }}">
                          {{ trans('global.back') }} 
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.purchase_request.title_singular') }}
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
              
              <div class=" card-body p-0" id="datatable"> 
                {{-- <center><img src="C:\xampp\htdocs\DavNor-ProcSys\public\image\Letterhead.JPG"  class="img-fluid img-thumbnail"></center> --}}
                <p style="text-align:center; font-size: 20px; margin-top:20px "><b>PURCHASE REQUEST</b></p>                      
                <div style="margin-bottom:2px">                 
                    <span style="display:inline-block; ">
                        <p style="font-size: 12px; ">Entity Name: &nbsp;<b>DepEd, Division of Davao del Norte</b></p>
                    </span>
                    
                    <span style="display:inline-block; float:right; ">                        
                        <p style="font-size: 12px;">Fund Cluster: &nbsp;<b>{{ $data->fund_cluster }}</b></p>
                    </span>
                </div>
                <table  width="100%" style="margin-bottom:5px;">
                    <tr>
                        <td style="text-align:left; border: 1px solid black">                    
                            <p style=" padding-left:10px; font-size: 12px">Office / Section: &nbsp; <b>{{$data->office}}</b></p>                                      
                        </td>                    
                        <td width="38%" style="text-align:left; border: 1px solid black">                    
                            <p style="text-align:left; font-size: 12px;">PR Number: &nbsp; <b>{{$data->pr_no}}</b></p>
                            <p style=" font-size: 12px;"> Resposibility Center Code: &nbsp; <b>{{$data->res_code}}</b></b>
                        </td>
                        <td width="18%" style="text-align:left; border: 1px solid black">                    
                            <p style=" font-size: 12px;">Date: &nbsp; <b>{{$data->date}}</b></p>
                        </td>
                    </tr>
                </table>
                                        
                <table class="table table-sm" id="table" style="font-size: 12px; text-align:center; margin-bottom:5px; vertical-align:middle">
                    <thead>
                        <tr>                        
                            <th style="text-align:center; border: 1px solid black">Stock No.
                                
                            </th>
                            <th style="text-align:center; border: 1px solid black">Unit
                                
                            </th> 
                            <th width="50%" style="text-align:center; border: 1px solid black">Description
                            
                            </th>
                            <th style="text-align:center; border: 1px solid black" >Quantity
                                
                            </th>
                            <th style="text-align:center; border: 1px solid black">Unit <br>Price
                                
                            </th>                                
                            <th style="text-align:center; border: 1px solid black" >Total <br>Cost
                                
                            </th>
                        </tr>                        
                    </thead>
                    <tbody>
                      @foreach ($items as $item)
                      <tr>    
                          <td style="text-align:center; border: 1px solid black">{{ $item->stock_no }}</td>
                          <td style="text-align:center; border: 1px solid black">{{ $item->unit }}</td>
                          <td style="text-align:left; border: 1px solid black">{!! nl2br($item->description) !!}</td>    
                          <td style="text-align:center; border: 1px solid black">{{ $item->quantity }}</td>
                          <td style="text-align:right; border: 1px solid black">{{ number_format((float)$item->unit_price, 2, '.', ',') }}</td>
                          <td style="text-align:right; border: 1px solid black">{{ number_format((float)$item->total_cost, 2, '.', ',') }}</td>      
                      </tr>   
                      @endforeach
                    
                    <tr>
                        <td colspan="4" style="text-align:right; border: 1px solid black"><b>Total Cost </b></td>
                        <td colspan="2" style="text-align:right; border: 1px solid black">Php &nbsp;{{ number_format((float)$total_cost, 2, '.', ',') }}</td>
                    </tr>  
                  </tbody>
                </table>
            
                <table width="100%">                    
                    <tr>
                        <td colspan="2" style="text-align:left; border: 1px solid black; border-bottom: 0px; font-size: 12px">                    
                            <p style="padding-left: 3px;">Purpose: <b>{{$data->purpose}}</b></p>  
                            <p style="padding-left: 3px;">Source of Fund: <b>{{$data->fund_source}}</b></p>                                   
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="text-align:left; border: 1px solid black">                    
                            <p style="padding-bottom:10px; font-size: 12px;">Requested by: </u></p>                                    
                            <p style="padding-left:15px; font-size: 12px;">Signature: </u></p>                                      
                            <p style="padding-left:15px; font-size: 11px;">Printed Name:&nbsp;&nbsp; <b>{{strtoupper($data->requested_by)}}</b><br>                                      
                                                                            Designation: &nbsp;&nbsp;<b>{{$data->designation}}</b></p>                                      
                        </td> 
                        <td width="50%" style="text-align:left; border: 1px solid black">                    
                            <p style="padding-bottom:10px; font-size: 12px;">Approved by: </u></p>                                    
                            <p style=" padding-left:15px; font-size: 12px;">Signature: </u></p>                                      
                            <p style="padding-left:15px; font-size: 11px;">Printed Name: &nbsp;&nbsp;<b>{{ strtoupper($hope->fullname) }}</b><br>                                      
                                                                            Designation: &nbsp;&nbsp;<b>{{ ($hope->position) }}</b></p>         
                        </td>
                    </tr>
                </table> 
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