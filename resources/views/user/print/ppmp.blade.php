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
                        {{ trans('global.print') }} {{ trans('cruds.ppmp.title_singular') }}
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
                  <p style="text-align:center; font-size: 18px; margin-top:14px;"><b>PROJECT PROCUREMENT MANAGEMENT PLAN (PPMP)</b> <br>Calendar Year {{ $data->calendar_year }}</p>            
                  
              <div class="my_text">
                  <p style="font-size: 12px; ">End-user/Unit: <b><u>{{ $data->office }}</u></b></p>
              </div>

              <div class=" card-body p-0" id="datatable">
                                        
                <table class="border table table-sm" id="table" style="font-size: 12px; text-align:center; vertical-align:middle">
                    <thead>
                        <tr>
                            <!-- <th hidden>ID </th> -->
                            <th rowspan="3" width="6%" style="vertical-align:middle; border: 1px solid black">Code</th>
                            <th rowspan="3" width="20%" style="vertical-align:middle; border: 1px solid black">General Description</th>
                            <th rowspan="3" style="vertical-align:middle; border: 1px solid black">Unit of <br>Measure</th>
                            <th rowspan="3" style="vertical-align:middle; border: 1px solid black">Quantity/ <br>Size</th>
                            <th rowspan="3" width="6%" style="vertical-align:middle;  border: 1px solid black">Unit Cost</th>
                            <th rowspan="3" width="6%" style="vertical-align:middle; border: 1px solid black">Estimated <br>Budget</th>
                            <th rowspan="3" width="8%" style="vertical-align:middle; border: 1px solid black">Mode of Procurement</th>
                            <th colspan="12" style="text-align:center; border: 1px solid black" data-column_name="title">Schedule/Milestone of Activities</th>                   
                            
                        </tr>
                        <tr>
                            <th colspan="3" style="border: 1px solid black">1st Quarter</th>
                            <th colspan="3" style="border: 1px solid black">2nd Quarter</th>
                            <th colspan="3" style="border: 1px solid black">3rd Quarter</th>
                            <th colspan="3" style="border: 1px solid black">4th Quarter</th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black">Jan</th>
                            <th style="border: 1px solid black">Feb</th>
                            <th style="border: 1px solid black">Mar</th>
                            <th style="border: 1px solid black">Apr</th>
                            <th style="border: 1px solid black">May</th>
                            <th style="border: 1px solid black">Jun</th>
                            <th style="border: 1px solid black">Jul</th>
                            <th style="border: 1px solid black">Aug</th>
                            <th style="border: 1px solid black">Sep</th>
                            <th style="border: 1px solid black">Oct</th>
                            <th style="border: 1px solid black">Nov</th>
                            <th style="border: 1px solid black">Dec</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($items as $data)
                        <tr>
                            <td style="border: 1px solid black">{{ $data->code }}</td>
                            <td style="border: 1px solid black; text-align:left">{!! nl2br($data->description) !!}</td>
                            <td style="border: 1px solid black">{{ $data->unit }}</td>
                            <td style="border: 1px solid black">{{ $data->quantity }}</td>
                            <td class="pr-3" style="border: 1px solid black; text-align:right">{{ number_format((float)$data->cost, 2, '.', ',') }}</td>
                            <td class="pr-3" style="border: 1px solid black; text-align:right">{{ number_format((float)$data->budget, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black">{{ $data->mode }}</td>
                            <td style="border: 1px solid black">{{ $data->jan }}</td>
                            <td style="border: 1px solid black">{{ $data->feb }}</td>
                            <td style="border: 1px solid black">{{ $data->mar }}</td>
                            <td style="border: 1px solid black">{{ $data->apr }}</td>
                            <td style="border: 1px solid black">{{ $data->may }}</td>
                            <td style="border: 1px solid black">{{ $data->jun }}</td>
                            <td style="border: 1px solid black">{{ $data->jul }}</td>
                            <td style="border: 1px solid black">{{ $data->aug }}</td>
                            <td style="border: 1px solid black">{{ $data->sep }}</td>
                            <td style="border: 1px solid black">{{ $data->oct }}</td>
                            <td style="border: 1px solid black">{{ $data->nov }}</td>
                            <td style="border: 1px solid black">{{ $data->dec }}</td>                                                              
                        </tr>   
                      @endforeach                      
                    </tbody>                                   
                </table> 
                <div>
                    <a style="font-size: 12px; text-align:left"> Estimated Budget:  &nbsp;&nbsp; <b>Php &nbsp;{{ number_format((float)$sum_budget, 2, '.', ',') }}</b></a>
                 </div>  
                <br><br> 
                <div class="row">
                    <div class="column" style="width:30%">
                      <p style="font-size: 12px;"><b><u>{{ strtoupper($end_user->prepared_by) }}</u></b><br>
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