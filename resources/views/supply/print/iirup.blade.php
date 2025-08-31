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
                        {{ trans('global.print') }} {{ trans('cruds.iirup_item.title_short') }}
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
                    
              <p style="text-align:right; font-size: 12px;"><i>Annex A.10</i></p>                                    
              <p style="text-align:center; font-size: 20px; bottom-margin: 30px;"><b>INVENTORY AND INSPECTION REPORT OF UNSERVICEABLE PROPERTY</b></p>
              
              <p style="text-align:center; font-size: 12px;">As at <u><b>{{ \Carbon\Carbon::parse($iirupData->date)->format('F j, Y') }}</b></u></p>
              
              <div class="row">
                  <div class="column" style="width:70%; margin-top: 15px; text-align: left;">
                    <h5 style="text-align: left; font-size: 12px; margin-left: 20px">Entity Name: &nbsp;<b>DepEd Division of Davao del Norte</b></h5> 
                  </div>
                  <div class="column" style="width:30%; margin-top: 15px; text-align: center;">
                    <h5 style="text-align: right; font-size: 12px; margin-right: 20px">Fund Cluster: &nbsp;<b>{{ '01' }}</b></h5>
                  </div>
              </div>
              <div class="row">
                  <div class="column" style="width:30%; text-align: center;">
                    <p style="font-size: 12px;"><b><u>{{ strtoupper($iirupData->accountable_officer) }}</u></b><br>
                    <i>{{ '(Name of Accountable Officer)' }}</i></p>
                  </div>
                  <div class="column" style="width:30%; text-align: center;">
                    <p style="font-size: 12px;"> <b><u>{{ strtoupper($iirupData->position) }}</u></b><br>
                    <i>{{ '(Designation)' }}</i></p>
                  </div>
                  <div class="column" style="width:30%; text-align: center;">
                      <p style="font-size: 12px;"><b><u>{{ strtoupper($iirupData->station) }}</u></b><br>
                      <i>{{ '(Station)' }}</p>
                  </div>
              </div>     
              <div class=" card-body p-0" id="datatable">
                                        
                <table class="border table table-sm" id="table" style="font-size: 11px; text-align:center; vertical-align:middle">
                    <thead>
                        <tr>                      
                            <th colspan='10' style="border: 1px solid #000000;">
                                {{ 'INVENTORY' }}
                            </th>
                            <th colspan='8' style="border: 1px solid #000000;">
                                {{ 'INSPECTION and DISPOSAL' }}
                            </th>
                        </tr>
                        <tr>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.date_acquired') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.particulars') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.property_no') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.quantity') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.unit_cost') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.total_cost') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.depreciation') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.losses') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.carrying_amount') }}
                            </th>
                            <th rowspan='3' style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.remarks') }}
                            </th>
                        </tr>
                        <tr>                            
                            <th colspan='5' style="border: 1px solid #000000;">
                                {{ 'DISPOSAL' }}
                            </th>
                            <th rowspan="2" style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.appraised_value') }}
                            </th>
                            <th colspan='2' style="border: 1px solid #000000;">
                                {{ 'RECORD OF SALES' }}
                            </th>
                        </tr>
                        <tr>
                            <th style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.sale') }}
                            </th>
                            <th style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.transfer') }}
                            </th>
                            <th style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.destruction') }}
                            </th>
                            <th style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.others') }}
                            </th>
                            <th style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.total_dispose') }}                          
                            </th>
                            <th style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.or_no') }}
                            </th>
                            <th style="vertical-align:middle; border: 1px solid #000000;">
                                {{ trans('cruds.iirup_item.fields.amount') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($items as $data)
                        <tr>
                            <td style="border: 1px solid black">{{ $data->date_acquired }}</td>
                            <td style="border: 1px solid black; text-align:left">{!! nl2br($data->particulars) !!}</td>
                            <td style="border: 1px solid black">{{ $data->property_no }}</td>
                            <td style="border: 1px solid black">{{ $data->quantity }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->unit_cost, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->total_cost, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->depreciation, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->losses, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->carrying_amount, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black">{{ $data->remarks }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->sale, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->transfer, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->destruction, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->others, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->total_dispose, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->appraised_value, 2, '.', ',') }}</td>
                            <td style="border: 1px solid black">{{ $data->or_no }}</td>
                            <td style="border: 1px solid black; text-align:right">{{ number_format((float)$data->amount, 2, '.', ',') }}</td>     
                        </tr>   
                      @endforeach                      
                    </tbody>                     
                      <tr>                        
                      <td colspan="10" style="text-align: center; border: 1px solid #000000;">
                              <p style="text-align: left; font-size: 12px; margin: 5px 10px 30px;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I HEREBY request inspection and disposition, pursuant to Section 79 of PD 1445, of the property enumeerated above. 
                              </p>
                              <div style="display: flex; justify-content: space-between; align-items: flex-start; padding: 0 10px;">
                                  <!-- Requested By -->
                                  <div style="width: 40%; text-align: center;">
                                      <p style="text-align: left; font-size: 12px; margin-bottom: 40px;">Requested By:</p>
                                      <p style="font-size: 12px;">
                                          <b><u>{{ strtoupper($iirupData->requester) }}</u></b><br>
                                          Property Custodian
                                      </p>
                                  </div>

                                  <!-- Spacer -->
                                  <div style="width: 10%;"></div>

                                  <!-- Approved By -->
                                  <div style="width: 40%; text-align: center;">
                                      <p style="text-align: left; font-size: 12px; margin-bottom: 40px;">Approved By:</p>
                                      <p style="font-size: 12px;">
                                          <b><u>{{ strtoupper($iirupData->accountable_officer) }}</u></b><br>
                                          School Head
                                      </p>
                                  </div>
                              </div>
                          </td>
                          <td colspan="8" style="border: 1px solid #000000; text-align: center; padding: 10px;">
                              <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                  
                                  <!-- Supply Officer Block -->
                                  <div style="width: 50%; text-align: center;">
                                      <p style="text-align: justify; font-size: 12px; margin: 5px 0 40px;">
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I CERTIFY that I have inspected each and every article enumerated in this report, and that the disposition made thereof was, in my judgment, the best for the public interest.
                                      </p>
                                      <p style="font-size: 12px;">
                                          <b><u>{{ strtoupper($supply_officer->fullname) }}</u></b><br>
                                          Supply Officer
                                      </p>
                                  </div>

                                  <!-- Spacer -->
                                  <div style="width: 5%;"></div>

                                  <!-- Auditor Block -->
                                  <div style="width: 40%; text-align: center;">
                                      <p style="text-align: justify; font-size: 12px; margin: 5px 0 40px;">
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I CERTIFY that I have witnessed the disposition of the articles enumerated on this report this _____ day of _____________, _______.
                                      </p>
                                      <p style="font-size: 12px;">
                                          <b><u>{{ strtoupper($auditor->fullname) }}</u></b><br>
                                          State Auditor IV
                                      </p>
                                  </div>

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