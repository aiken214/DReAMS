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
                        <p style="text-align:center; font-size: 14px"><b>DepEd, Division of Davao del Norte {{ $app_data->title }} {{ $app_data->calendaryear }}</b>  
                    </div>
                        <div class=" card-body p-0" id="datatable">                        
                            <table class="table table-sm" id="table" cellspacing="0" cellspading="0">
                                <thead>
                                    <tr>
                                        <!-- <th hidden>ID </th> -->
                                        <th rowspan="2" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Code<br>(PAP)</th>
                                        <th rowspan="2" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Project<br>Procurement</th>
                                        <th rowspan="2" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">PMO/ <br>End-User</th>
                                        <th rowspan="2" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Is this an <br>Early <br>Procurement <br>Activity?<br> Yes/No</th>
                                        <th rowspan="2" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Mode of Procurement</th>
                                        <th colspan="4" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Schedule for Each Procurement Activity</th>
                                        <th rowspan="2" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Source of Funds</th> 
                                        <th colspan="3" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Estimated Budget (PhP)</th> 
                                        <th rowspan="2" style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Remarks <br>(Brief description of the <br>Project)</th> 
                                        
                                    </tr>
                                    <tr>
                                        <th style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Advertiseme<br>nt/Posting of<br>IB/REI</th>
                                        <th style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Submission<br>/Opening of<br>Bids</th>
                                        <th style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Notice of<br>Award</th>
                                        <th style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Contract<br>Signing</th>
                                    
                                        <th style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">Total</th>
                                        <th style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">MOOE</th>
                                        <th style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">CO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($app_item_data as $data)
                                    <tr>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ $data->code }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:left; border: 1px solid black">{{ $data->ppmp }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ $data->enduser }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ $data->epa }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ "Competitive Bidding" }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ $data->posting }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ $data->opening }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ $data->noa }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ $data->contract }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:center; border: 1px solid black">{{ $data->fund_source }}</td>
                                        <td class="pr-3" style="font-size: 12px; vertical-align:middle; text-align:right; border: 1px solid black">{{ number_format((float)$data->amount, 2, '.', ',') }}</td>
                                        <td class="pr-3" style="font-size: 12px; vertical-align:middle; text-align:right; border: 1px solid black">{{ number_format((float)$data->mooe_budget, 2, '.', ',') }}</td>
                                        <td class="pr-3" style="font-size: 12px; vertical-align:middle; text-align:right; border: 1px solid black">{{ number_format((float)$data->co_budget, 2, '.', ',') }}</td>
                                        <td style="font-size: 12px; vertical-align:middle; text-align:left; border: 1px solid black">{!! nl2br($data->remarks) !!}</td>
                                                
                                    </tr>   
                                    @endforeach
            
                                </tbody>               
            
                            </table> 
                            <br>  
                            <div>
                                {{ "Prepared by:" }}
                            </div><br>
                            <div class="row">
                                <div class="column">
                                  <p style="font-size: 12px;"><b><u>{{ strtoupper($bac_sec->fullname) }}</u></b><br>
                                  {{ "BAC Secretariate Chair" }}</p>
                                </div>
                            </div>
                            <div>
                                {{ "Recommending Approval:" }}
                            </div><br>
                            <div class="row">
                                <div class="column" style="width:18%">
                                  <p style="font-size: 12px;"> <b><u>{{ strtoupper($bac_chair->fullname) }}</u></b><br>
                                  {{ "BAC Chairperson" }}</p>
                                </div>
                                <div class="column" style="width:18%">
                                    <p style="font-size: 12px;"><b><u>{{ strtoupper($bac_vice_chair->fullname) }}</u></b><br>
                                    {{ "BAC Vice-Chairperson" }}</p>
                                </div>
                                <div class="column" style="width:18%">
                                    <p style="font-size: 12px;"><b><u>{{ strtoupper($bac_member[0]->fullname) }}</u></b><br>
                                    {{ "BAC Member" }}</p>
                                </div>
                                <div class="column" style="width:18%">
                                    <p style="font-size: 12px;"><b><u>{{ strtoupper($bac_member[1]->fullname) }}</u></b><br>
                                    {{ "BAC Member" }}</p>
                                </div>
                                <div class="column" style="width:18%">
                                    <p style="font-size: 12px;"><b><u>{{ strtoupper($bac_member[2]->fullname) }}</u></b><br>
                                    {{ "BAC Member" }}</p>
                                </div>
                            </div><br>
                            <div>
                                {{ "Approved by:" }}
                            </div><br> 
                            <div class="column">
                                <p style="font-size: 12px;"> <b><u>{{ strtoupper($hope->fullname) }}</u></b><br>
                                {{ "SDS/Head of Procuring Entity" }}</p>
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