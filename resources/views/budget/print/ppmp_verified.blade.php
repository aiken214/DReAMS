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
          @can('ppmp_verify_access')
              <div style="margin-bottom: 10px;" class="row">
                  <div class="col-lg-12">
                      <a class="btn btn-default" href="{{ route('budget.ppmp_verify.verified')}}">
                          {{ trans('global.back') }} 
                      </a>
                      <a class="btn btn-secondary" style="color: white;" onclick="printPage('test')">
                          {{ trans('global.print') }} {{ trans('global.verified') }} {{ trans('cruds.ppmp.title_singular') }} {{ trans('global.list') }}
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
                               
                    <p style="text-align:center; font-size: 20px;"><b>List of Verified PPMP</b></p>

                    <table style="width: 100%; margin: 0px 15px 0px 15px" cellspacing="0" cellspading="0">                    
                        <tr>
                            <td style="width: 50%">                    
                                <h5 style="text-align: left; font-size: 12px; margin-left: 20px">Entity Name: &nbsp;<b>DepEd Division of Davao del Norte - Budget office</b></h5>                                                                          
                            </td>
                            <td style="width: 50%">                                       
                                <h5 style="text-align: right; font-size: 12px; margin-right: 40px">Period: &nbsp;<b>{{ $from }} - {{ $to }}</b></h5>
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%; margin: 10px 15px 10px 15px," cellspacing="0" cellspading="0">
                            
                        <tr>
                            <td style="text-align:center; height:40px; font-size: 12px; border: 1px solid black"><b>Calendar Year</b></td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Title</b></td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Type</b></td>
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Category</b></td>                                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Requester</b></td>                                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Station</b></td>                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Fund Source</b></td>                 
                            <td style="text-align:center; font-size: 12px; border: 1px solid black"><b>Allocated Budget</b></td>                 
                        </tr>
                        @foreach ($items as $data)
                          <tr>
                              <td style="width:5%; text-align:center; font-size: 12px; border: 1px solid black">{{ $data->calendar_year }}</td>
                              <td style="width:25%; text-align:left; font-size: 12px; border: 1px solid black; padding:5px">{{ $data->title }}</td>
                              <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->type }}</td>
                              <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->category }} </td>
                              <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->prepared_by }}</td>                                   
                              <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->station }}</td>                            
                              <td style="text-align:center; font-size: 12px; border: 1px solid black">{{ $data->fund_source }}</td>                            
                              <td style="width:8%; text-align:right; font-size: 12px; border: 1px solid black; padding:5px">{{ number_format((float)$data->budget_alloc, 2, '.', ',') }}</td>                      
                          </tr> 
                        @endforeach                               
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
            html += "@page { size: A4 landscape; margin: 10mm; }"; // Set A4 portrait
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