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
                      <a class="btn btn-default" href="{{ route('supply.rsmi.index2', $data->id) }}">
                          {{ trans('global.back') }} 
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('cruds.rsmi.title_short') }}
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

                <p style="text-align:right; font-size: 12px;"><i>Appendix 64</i></p>                                    
                <p style="text-align:center; font-size: 20px;"><b>Report of Supplies and Materials Issued</b></p>
                
                <table style="width: 100%; margin: 0px 15px 0px 10px" cellspacing="0" cellspading="0">                    
                    <tr>
                        <td style="width: 70%">                    
                            <p style="text-align: left; vertical-align: top; font-size: 12px; margin-left: 5px">Entity Name: &nbsp;<b>{{ $data->entity_name }}</b> 
                            <br>Fund Cluster: &nbsp;<b>{{ $data->fund_cluster }}</b></p>              
                        </td>
                        <td style="width: 30%"> 
                            <p style="text-align: left; vertical-align: top; font-size: 12px; margin-left: 20px">Serial No.: &nbsp;<b>{{ $data->rsmi_no }}</b>             
                            <br>Date: &nbsp;<b>{{ \Carbon\Carbon::parse($data->rsmi_date)->format('F Y') }}</b></p>              
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0">
                    <tr>
                        <td colspan = "6" style="width: 50%; height:40px; text-align:center; font-size: 12px; border: 1px solid black">                    
                            <i><b>To be filled up by the Supply and/or Property Custodian</i></b>                                   
                        </td>
                        <td colspan = "2" style="width: 50%; text-align:center; font-size: 12px; border: 1px solid black">                    
                            <i><b>To be filled up by the Accounting Division/Unit</i></b>                                   
                        </td>
                    </tr>    
                    <tr>
                        <td style="width:14%; height:40px; text-align:center; font-size: 12px; border: 1px solid black"><b>RIS No.</b></td>
                        <td style="width:10%; text-align:center; font-size: 12px; border: 1px solid black"><b>Responsibility Center Code</b></td>
                        <td style="width:8%; text-align:center; font-size: 12px; border: 1px solid black"><b>Stock No.</b></td>                                 
                        <td style="width:30%; text-align:center; font-size: 12px; border: 1px solid black"><b>Item</b></td>                                 
                        <td style="width:8%; text-align:center; font-size: 12px; border: 1px solid black"><b>Unit</b></td>                                 
                        <td style="width:10%; text-align:center; font-size: 12px; border: 1px solid black"><b>Quantity Issued</b></td>                                 
                        <td style="width:10%; text-align:center; font-size: 12px; border: 1px solid black"><b>Unit Cost</b></td>                                 
                        <td style="width:10%; text-align:center; font-size: 12px; border: 1px solid black"><b>Amount</b></td>                                 
                    </tr> 

                    

                    @php
                        $rowspan_counts = []; // Store counts of how many rows each ris_no has
                    @endphp

                    {{-- Count occurrences of each ris_no --}}
                    @foreach ($table_data1 as $table_datum1)
                        @php
                            $ris_no = $table_datum1['ris_no'] ?? 'N/A';
                            $rowspan_counts[$ris_no] = isset($rowspan_counts[$ris_no]) ? $rowspan_counts[$ris_no] + 1 : 1;
                        @endphp
                    @endforeach

                    @php
                        $printed_ris_no = []; // Track which ris_no has been printed
                    @endphp

                    @foreach ($table_data1 as $table_datum1)
                        @php
                            $ris_no = $table_datum1['ris_no'] ?? 'N/A';
                        @endphp
                        <tr>                                    
                            {{-- Only show ris_no on the first occurrence, and set rowspan --}}
                            @if (!isset($printed_ris_no[$ris_no]))
                                <td rowspan="{{ $rowspan_counts[$ris_no] }}" style="text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black;">
                                    {{ $ris_no }}
                                </td>
                                @php
                                    $printed_ris_no[$ris_no] = true; // Mark as printed
                                @endphp
                            @endif
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"></td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum1['stock_no'] }}</td>
                            <td style="padding-left: 5px; font-size: 12px; border: 1px solid black">{{ $table_datum1['description'] }}</td>                                   
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum1['unit'] }}</td>                                   
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum1['issued_quantity'] }}</td>                                   
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">
                                {{ number_format((float)$table_datum1['unit_cost'], 2, '.', ',') }}
                            </td> 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black">
                                {{ number_format((float)$table_datum1['issued_quantity'] * $table_datum1['unit_cost'], 2, '.', ',') }}
                            </td>                                                                 
                        </tr> 
                    @endforeach
                </table>  
                <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0"> 
                    <tr>
                        <td colspan = "7" style="width: 50%; height:40px; text-align:left; padding-left: 20px; font-size: 12px; border: 1px solid black">                    
                            <i><b>Recapitulation</i></b>                                   
                        </td>
                        
                    </tr>  
                    <tr>
                        <td style="width:12%; height:40px; text-align:center; font-size: 12px; border: 1px solid black"><b>Stock No.</b></td>
                        <td style="width:10%; text-align:center; font-size: 12px; border: 1px solid black"><b>Quantity</b></td>
                        <td style="width:40%; text-align:center; font-size: 12px; border: 1px solid black"><b>Item</b></td>                                 
                        <td style="width:8%; text-align:center; font-size: 12px; border: 1px solid black"><b>Unit</b></td>                                 
                        <td style="width:10%; text-align:center; font-size: 12px; border: 1px solid black"><b>Unit Cost</b></td>                                 
                        <td style="width:10%; text-align:center; font-size: 12px; border: 1px solid black"><b>Total Cost</b></td>                                 
                        <td style="width:10%; text-align:center; font-size: 12px; border: 1px solid black"><b>UACS Object Code</b></td>                        
                    </tr> 
                    @foreach ($table_data2 as $table_datum2)                                 
                    <tr>                                    
                          <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum2->stock_no }}</td>
                          <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum2->receipt_quantity }}</td>
                          <td style="padding-left: 5px; font-size: 12px; border: 1px solid black">{{ $table_datum2->description }}</td>                                   
                          <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $table_datum2->unit }}</td>   
                          <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ number_format((float)$table_datum2->unit_price, 2, '.', ',')  }}</td>    
                          <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ number_format((float)$table_datum2->total_amount, 2, '.', ',')  }}</td>  
                          <td style="text-align:center; font-size: 12px; border: 1px solid black"> </td>                                                              
                    </tr> 
                    @endforeach
                </table>
                <table style="width: 100%; margin: 10px 15px 0px 15px," cellspacing="0" cellspading="0">                    
                                      
                    <tr>
                        <td width="50%" style="font-size: 12px; border: 1px solid black">                    
                            <p style="margin:10px 10px 10px 10px; font-size: 12px">RECOMMENDING APPROVAL:<br><br>
                                &nbsp;&nbsp;&nbsp;I hereby certify to the corrections of the above information.</p> 
                            <div class="row justify-content-center" style="margin-top: 60px;">
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                <b><u>{{ strtoupper($supply_officer->fullname) }}</u></b>
                                <br>Signature Over Printed Name of Supply and/or Property Custodian
                              </p>                                    
                            </div><br> 
                        </td> 
                        <td width="50%" style="font-size: 12px; border: 1px solid black">                    
                            <p style="margin:10px 10px 10px 10px; font-size: 12px">APPROVED BY:</p>                                    
                            <div class="row justify-content-center" style="margin-top: 90px;">
                              <p style="text-align: center; font-size: 12px; margin: 1px; padding: 1px">
                                <b><u>{{ strtoupper($admin_officer->fullname) }}</u></b>
                                <br>Administrative Officer V
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