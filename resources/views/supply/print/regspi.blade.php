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
        @can('ppmp_print')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-default" href="{{ URL::previous() }}">
                        {{ trans('global.back') }} 
                    </a>
                    <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                        {{ trans('global.print') }} {{ trans('cruds.regspi.title_short') }}
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
                    
              <p style="text-align:right; font-size: 12px;"><i>Appendix A.4</i></p>                                    
              <p style="text-align:center; font-size: 20px; bottom-margin: 30px;"><b>REGISTRY OF SEMI-EXPENDABLE PROPERTY ISSUED</b></p>
              
              <table style="width: 100%; margin: 0px 15px 0px 15px" cellspacing="0" cellspading="0">                    
                  <tr>
                      <td style="width: 50%">                    
                          <h5 style="text-align: left; font-size: 12px; margin-left: 20px">Entity Name: &nbsp;<b>DepEd Davao del Norte</b></h5>                                                                                                 
                          <h5 style="text-align: left; font-size: 12px; margin-left: 20px">Semi-Expendable Property: &nbsp;<b>@isset($type) {{ $type }} @endisset</b></h5>                                                                                       
                      </td>
                      <td style="width: 50%"> 
                          <h5 style="text-align: center; font-size: 12px; margin-left: 20px">Fund Cluster: &nbsp;<b>{{ '01' }}</b></h5>              
                          <h5 style="text-align: center; font-size: 12px; margin-left: 20px">Sheet No.: &nbsp;<b>_____</b></h5>              
                      </td>
                  </tr>
              </table>

              <div class=" card-body p-0" id="datatable">
                                        
                <table class="border table table-sm" id="table" style="font-size: 12px; text-align:center; vertical-align:middle">
                    <thead>
                      <tr>
                          <th rowspan='2' style="text-align:center; vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.date') }}
                          </th>
                          <th colspan='2' style="text-align:center; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.reference') }}
                          </th>
                          <th rowspan='2' style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.description') }}
                          </th>
                          <th rowspan='2' style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.lifespan') }}
                          </th>
                          <th colspan='2' style="text-align:center; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.issued') }}
                          </th>
                          <th colspan='2' style="text-align:center; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.returned') }}
                          </th>
                          <th colspan='2' style="text-align:center; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.reissued') }}
                          </th>
                          <th rowspan='1' style="text-align:center; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.disposed') }}
                          </th>
                          <th rowspan='1' style="text-align:center; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.balance') }}
                          </th>
                          <th rowspan='2' style="text-align:center; vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.amount') }}
                          </th>
                          <th rowspan='2' style="text-align:center; vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.remarks') }}
                          </th>
                      </tr>
                      <tr>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.ref_no') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black;">
                              {{ trans('cruds.regspi.fields.inventory_item_no') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.quantity') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.office') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.quantity') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.office') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.quantity') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.office') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.quantity') }}
                          </th>
                          <th style="vertical-align:middle; border: 1px solid black">
                              {{ trans('cruds.regspi.fields.quantity') }}
                          </th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $rowspan_counts = []; // Store counts of how many rows each (date, reference) pair has
                            $printed_reference = []; // Track which (date, reference) has been printed
                        @endphp

                        {{-- Count occurrences of each (date, reference) pair --}}
                        @foreach ($data as $item)
                            @php
                                $date = $item['date'] ?? 'N/A';
                                $reference = $item['reference'] ?? 'N/A';
                                $key = $date . '-' . $reference; // Unique key for tracking (Date + ICS No.)
                                
                                $rowspan_counts[$key] = isset($rowspan_counts[$key]) ? $rowspan_counts[$key] + 1 : 1;
                            @endphp
                        @endforeach

                        @foreach ($data as $item)
                            @php
                                $date = $item['date'] ?? 'N/A';
                                $reference = $item['reference'] ?? 'N/A';
                                $key = $date . '-' . $reference;
                            @endphp
                            <tr>
                                {{-- Only show date on the first occurrence of the (date, reference) group --}}
                                @if (!isset($printed_reference[$key]))
                                    <td rowspan="{{ $rowspan_counts[$key] }}" 
                                        style="text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black;">
                                        {{ $date }}
                                    </td>
                                    <td rowspan="{{ $rowspan_counts[$key] }}" 
                                        style="text-align:center; vertical-align:middle; font-size: 12px; border: 1px solid black;">
                                        {{ $reference }}
                                    </td>
                                    @php
                                        $printed_reference[$key] = true; // Mark (date, reference) as printed
                                    @endphp
                                @endif
                                <td style="border: 1px solid black">{{ $item['property_no'] }}</td>
                                <td style="border: 1px solid black; text-align:left">{!! nl2br($item['description']) !!}</td>
                                <td style="border: 1px solid black">{{ $item['lifespan'] }}</td>
                                <td style="border: 1px solid black">{{ $item['issued_qty'] }}</td>
                                <td style="border: 1px solid black">{!! $item['issued_office'] !!}</td>
                                <td style="border: 1px solid black">{{ $item['re-issued_qty'] }}</td>
                                <td style="border: 1px solid black">{!! $item['re-issued_office'] !!}</td>
                                <td style="border: 1px solid black">{{ $item['returned_qty'] }}</td>
                                <td style="border: 1px solid black">{!! $item['returned_office'] !!}</td>
                                <td style="border: 1px solid black">{{ $item['disposed_qty'] }}</td>                
                                <td style="border: 1px solid black">{{ $item['balance_qty'] }}</td>                  
                                <td style="text-align:right; border: 1px solid black">{{ number_format((float)$item['amount'], 2, '.', ',') }}</td> 
                                <td style="border: 1px solid black">{{ $item['remarks'] }}</td>                                                          
                            </tr>   
                        @endforeach                      
                    </tbody>                                   
                </table>
                <br>
                <div class="row">
                    <div class="column" style="width:50%; text-align: center;">
                      <p style="text-align: left; font-size: 12px; margin-bottom: 40px;">Certified Correct By:</p>
                      <p style="font-size: 12px;"><b><u>{{ strtoupper($supply_officer->fullname) }}</u></b><br>
                      {{ $supply_officer->position }}</p>
                    </div>
                    <div class="column" style="width:50%; text-align: center;">
                    <p style="text-align: left; font-size: 12px; margin-bottom: 40px;">Approved By:</p>
                      <p style="font-size: 12px;"> <b><u>{{ strtoupper($hope->fullname) }}</u></b><br>
                      {{ $hope->position }}</p>
                    </div>
                </div>         
              </div>                                
            </div>
          </div>
        </div>
      </div> 
    </div>
  </section>
  
  @endsection 

  @section('scripts')
      <script>
        function printPage(id) {
            var html = "<html>";
            html += "<head>";
            html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />";
            html += "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />";
            html += "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css'>";
            html += "<style>";
            html += "@page { size: A4 landscape; margin: 10mm; }"; // Set A4 landscape
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