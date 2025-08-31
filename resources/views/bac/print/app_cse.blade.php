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
                        {{ trans('global.print') }} {{ trans('cruds.app.title_singular') }}
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
                    
              <div class="my_text">
                <p style="text-align:left; font-size: 14px"><b>DepEd, Division of Davao del Norte</b>            
                <br>Mankilam, Tagum City, Davao del Norte</p>
              </div>

              <div class="my_text">
                  <p style="text-align:center; font-size: 16px; margin-top:14px;"><b>ANNUAL PROCUREMENT PLAN (APP) - COMMON-USE SUPPLIES AND EQUIPMENT (APP-CSE) {{ $appData->calendar_year }} FORM</b></p>            
                  
              <div class="my_text">
                  <p style="font-size: 12px; ">Title: <b><u>{{ $appData->title }}</u></b></p>
              </div>

              <div class=" card-body p-0" id="datatable">
                                        
                <table class="border table table-sm" id="table" style="font-size: 10px; text-align:center; vertical-align:middle">
                    <thead>
                        <tr>
                            <!-- <th hidden>ID </th> -->
                            <th rowspan="2" style="vertical-align:middle; border: 1px solid black">No.</th>
                            <th rowspan="2" width="6%" style="vertical-align:middle; border: 1px solid black">Code</th>
                            <th rowspan="2" width="20%" style="vertical-align:middle; border: 1px solid black">General Description</th>
                            <th rowspan="2" style="vertical-align:middle; border: 1px solid black">Unit of <br>Measure</th>
                            <th colspan="20" style="text-align:center; border: 1px solid black" data-column_name="title">Monthly Quantity Requirement</th> 
                            <th rowspan="2" style="vertical-align:middle; border: 1px solid black">Total Quantity<br>of the Year</th>
                            <th rowspan="2" style="vertical-align:middle;  border: 1px solid black">Price</th>
                            <th rowspan="2" width="6%" style="vertical-align:middle; border: 1px solid black">Total Amount<br>of the Year</th>                  
                            
                        </tr>
                        <tr>
                            <th style="border: 1px solid black">Jan</th>
                            <th style="border: 1px solid black">Feb</th>
                            <th style="border: 1px solid black">Mar</th>
                            <th style="border: 1px solid black">Q1</th>
                            <th style="border: 1px solid black">Q1<br>Amount</th>
                            <th style="border: 1px solid black">Apr</th>
                            <th style="border: 1px solid black">May</th>
                            <th style="border: 1px solid black">Jun</th>
                            <th style="border: 1px solid black">Q2</th>
                            <th style="border: 1px solid black">Q2<br>Amount</th>
                            <th style="border: 1px solid black">Jul</th>
                            <th style="border: 1px solid black">Aug</th>
                            <th style="border: 1px solid black">Sep</th>
                            <th style="border: 1px solid black">Q3</th>
                            <th style="border: 1px solid black">Q3<br>Amount</th>
                            <th style="border: 1px solid black">Oct</th>
                            <th style="border: 1px solid black">Nov</th>
                            <th style="border: 1px solid black">Dec</th>
                            <th style="border: 1px solid black">Q4</th>
                            <th style="border: 1px solid black">Q4<br>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php $counter = 1; @endphp
                      @foreach ($ppmpData as $data)

                        <td colspan="27"  style="text-align:left; border: 1px solid black"><strong>{{ $data->title }}</strong></td>

                        @foreach ($data->ppmp_item as $item)

                        @php                  
                            $q1 = $item->jan + $item->feb + $item->mar; // Sum Q1
                            $q1amount = $q1 * $item->cost; // Multiply by cost

                            $q2 = $item->apr + $item->may + $item->jun; // Sum Q2
                            $q2amount = $q2 * $item->cost; // Multiply by cost

                            $q3 = $item->jul + $item->aug + $item->sep; // Sum Q3
                            $q3amount = $q3 * $item->cost; // Multiply by cost

                            $q4 = $item->oct + $item->nov + $item->dec; // Sum Q4
                            $q4amount = $q4 * $item->cost; // Multiply by cost
                        @endphp
                          <tr>
                              <td style="border: 1px solid black">{{ $counter++ }}</td> <!-- Incremental Number -->
                              <td style="border: 1px solid black">{{ $item->code }}</td>
                              <td style="border: 1px solid black; text-align:left">{!! nl2br(e(Str::words($item->description, 25, '...'))) !!}</td>
                              <td style="border: 1px solid black">{{ $item->unit }}</td>
                              <td style="border: 1px solid black">{{ $item->jan }}</td>
                              <td style="border: 1px solid black">{{ $item->feb }}</td>
                              <td style="border: 1px solid black">{{ $item->mar }}</td>
                              <td style="border: 1px solid black">{{ $q1 }}</td>
                              <td style="border: 1px solid black">{{ number_format((float)$q1amount, 2, '.', ',') }}</td>
                              <td style="border: 1px solid black">{{ $item->apr }}</td>
                              <td style="border: 1px solid black">{{ $item->may }}</td>
                              <td style="border: 1px solid black">{{ $item->jun }}</td>
                              <td style="border: 1px solid black">{{ $q2 }}</td>
                              <td style="border: 1px solid black">{{ number_format((float)$q2amount, 2, '.', ',') }}</td>
                              <td style="border: 1px solid black">{{ $item->jul }}</td>
                              <td style="border: 1px solid black">{{ $item->aug }}</td>
                              <td style="border: 1px solid black">{{ $item->sep }}</td>
                              <td style="border: 1px solid black">{{ $q3 }}</td>
                              <td style="border: 1px solid black">{{ number_format((float)$q3amount, 2, '.', ',') }}</td>
                              <td style="border: 1px solid black">{{ $item->oct }}</td>
                              <td style="border: 1px solid black">{{ $item->nov }}</td>
                              <td style="border: 1px solid black">{{ $item->dec }}</td>
                              <td style="border: 1px solid black">{{ $q4 }}</td>
                              <td style="border: 1px solid black">{{ number_format((float)$q4amount, 2, '.', ',') }}</td>
                              <td style="border: 1px solid black">{{ $item->quantity }}</td>
                              <td class="pr-3" style="border: 1px solid black; text-align:right">{{ number_format((float)$item->cost, 2, '.', ',') }}</td>
                              <td class="pr-3" style="border: 1px solid black; text-align:right">{{ number_format((float)$item->budget, 2, '.', ',') }}</td>                                                             
                          </tr>  
                        @endforeach 
                      @endforeach 
                      @php                  
                            $inflationCost = $sum_budget * 0.10; 
                            $grandTotal = $sum_budget + $inflationCost; 
                      @endphp
                      <tr>
                        <td colspan="27" height="15" style="text-align:left; border: 1px solid black"></td> 
                      </tr> 
                      <tr>
                        <td colspan="8"  style="text-align:left; border: 1px solid black"><strong>A. TOTAL</strong></td>                     
                        <td colspan="19"  style="text-align:right; border: 1px solid black"><strong>{{ number_format((float)$sum_budget, 2, '.', ',') }}</strong></td> 
                      </tr> 
                      <tr>
                        <td colspan="8"  style="text-align:left; border: 1px solid black"><strong>B. ADDITIONAL PROVISION FOR INFLATION (10% of TOTAL)</strong></td>                     
                        <td colspan="19"  style="text-align:right; border: 1px solid black"><strong>{{ number_format((float)$inflationCost, 2, '.', ',') }}</strong></td> 
                      </tr>  
                      <tr>
                        <td colspan="8"  style="text-align:left; border: 1px solid black"><strong>C. ADDITIONAL PROVISION FOR TRANSPORT AND FREIGHT COST (If Applicable)</strong></td>                     
                        <td colspan="19"  style="text-align:right; border: 1px solid black"><strong> </strong></td> 
                      </tr> 
                      <tr>
                        <td colspan="8"  style="text-align:left; border: 1px solid black"><strong>D. GRAND TOTAL (A + B + C)</strong></td>                     
                        <td colspan="19"  style="text-align:right; border: 1px solid black"><strong>{{ number_format((float)$grandTotal, 2, '.', ',') }}</strong></td> 
                      </tr>  
                      <tr>
                        <td colspan="8"  style="text-align:left; border: 1px solid black"><strong>E. APPROVED BUDGET BY THE AGENCY HEAD<br>In Figures and Words:</strong></td>                     
                        <td colspan="19"  style="text-align:right; border: 1px solid black"><strong><p style="text-align:left; padding-left:3px; font-size: 12px;">  
                          <?php                                    
                              $cost = number_format($grandTotal,2,".",""); 
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
                          </strong></td> 
                      </tr>                    
                    </tbody>                                   
                </table> 
                <br><br> 
                <div class="row">
                    <div class="column" style="width:30%">
                      <p style="font-size: 12px;"><b><u>{{ strtoupper($end_user->fullname) }}</u></b><br>
                      {{ "End User" }}</p>
                    </div>
                    <div class="column" style="width:30%">
                      <p style="font-size: 12px;"> <b><u>{{ strtoupper($budget_officer->fullname) }}</u></b><br>
                      {{ $budget_officer->position }}</p>
                    </div>
                    <div class="column" style="width:30%">
                        <p style="font-size: 12px;"><b><u>{{ strtoupper($hope->fullname) }}</u></b><br>
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