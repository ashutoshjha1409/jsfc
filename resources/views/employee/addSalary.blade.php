@extends('layouts.app')
@include('/layouts/navigation')
@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Basic Details</div>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6 details-tile-left">
                    <div class="field">
                        <div class="label">Name</div>
                        <div class="value">{{$data->name}}</div>
                    </div>
                    <div class="field">
                        <div class="label">Designation</div>
                        <div class="value">{{$data->designation}}</div>
                    </div>
                    <div class="field">
                        <div class="label">Location</div>
                        <div class="value">{{$data->location}}</div>
                    </div>
                    <div class="field">
                        <div class="label">Email</div>
                        <div class="value">{{$data->email}}</div>
                    </div>
                </div>
                <div class="col-sm-6 details-tile-right">
                    <div class="field">
                        <div class="label">Year</div>
                        <div class="value">
                            <select id="year_selected" name="year" class="form-control" data-toggle="tooltip" title="Select year" data-placement="right">
                                <option value="na">Select a year</option>
                                <script type="text/javascript">
                                    var dt = new Date();
                                    var yr = dt.getFullYear();
                                    for (var i = 2006; i < yr+1; i++) {
                                        document.write('<option value="'+i+'">'+i+'</option>');
                                    }
                                </script>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <div class="label">Admissable Pay</div>
                        <div class="value"><span id="total_admissable_pay">No Result</span></div>
                    </div>
                    <div class="field">
                        <div class="label">Pay Drawn</div>
                        <div class="value"><span id="total_pay_drawn">No Result</span></div>
                    </div>
                    <div class="field">
                        <div class="label">Net Income</div>
                        <div class="value"><span id="net_income">No Result</span></div>
                    </div>
                </div>
            </div>
            
            <!--<div class="row">
                
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="year_selected">Year: &nbsp;</label>
                        </div>
                        <div class="col-sm-6">
                            <select id="year_selected" name="year" class="form-control" data-toggle="tooltip" title="Select year" data-placement="right">
                                <option value="na">Select a year</option>
                                <script type="text/javascript">
                                    var dt = new Date();
                                    var yr = dt.getFullYear();
                                    for (var i = 2006; i < yr+1; i++) {
                                        document.write('<option value="'+i+'">'+i+'</option>');
                                    }
                                </script>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <b>Admissable Pay:</b>
                        </div>
                        <div class="col-sm-6"><span id="total_admissable_pay">No result</span></div>
                    </div>
                    <div class="row">    
                        <div class="col-sm-6">
                            <b>Pay Drawn:</b>
                        </div>
                        <div class="col-sm-6"><span id="total_pay_drawn">No result</span></div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-6">
                            <b>Net Income:</b>
                        </div>
                        <div class="col-sm-6"><span id="net_income">No Result</span></div>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
</div>
<div class="well">
    <div class="row table-row">
        <div class="col-md-12">
  <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#admissable" aria-controls="admissable" role="tab" data-toggle="tab">Admissable Pay</a></li>
                <li role="presentation"><a href="#drawn" aria-controls="drawn" role="tab" data-toggle="tab">Pay Drawn</a></li>
                <li role="presentation" id="difference_tab"><a href="#difference" aria-controls="difference" role="tab" data-toggle="tab">Difference</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="admissable">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="payByMonth">
                                <table class="table" id="admissable-table" data-st-id="ST_admissable-table">
                                    <thead>
                                       <tr>
                                            <th>Month</th>
                                            <th>Basic Pay</th>
                                            <th>DA(%)</th>
                                            <th>Area Type</th>
                                            <th>Action</th>
                                            <th>Total Pay</th>
                                            <th>H.R.A</th>
                                            <th>E.P.F</th>
                                            <th>Medical</th>
                                            <th>C.A</th>
                                            <th>Gross</th>
                                            <th>Deductions</th>
                                            <th>Net Pay</th>
                                       </tr> 
                                    </thead>
                                    <tbody>
                                        @foreach($data->months as $mon)
                                            <tr class="month-row rowHideable" id="{{ $mon['id'] }}">
                                                <td class="month">
                                                    {{ $mon['name'] }}
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                      <input type="text" class="form-control" placeholder="Basic pay" aria-describedby="sizing-addon2" name="bp" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                      <input type="text" class="form-control" placeholder="D.A" aria-describedby="sizing-addon2" name="da" value="" data-month="{{$mon['id']}}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                      <select name="areaType" >
                                                          <option value="0">Rural</option>
                                                          <option value="1">Urban</option>
                                                      </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary month-action" data-month="{{$mon['id']}}"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                </td>
                                                <td class="columnHideable total_pay"></td>
                                                <td class="columnHideable hra"></td>
                                                <td class="columnHideable epf"></td>
                                                <td class="columnHideable med"></td>
                                                <td class="columnHideable ca"></td>
                                                <td class="columnHideable gross"></td>
                                                <td class="columnHideable deductions"></td>
                                                <td class="columnHideable net"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>                                 
                                    
                               </table> 
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="user_id" value="{{$data->id}}">
                            </form>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="drawn">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="payByMonth_pd">
                                <table class="table">
                                   <tr>
                                        <th>Month</th>
                                        <th>Basic Pay</th>
                                        <th>DA(%)</th>
                                        <th>Area Type</th>
                                        <th>Action</th>
                                        <th>Total Pay</th>
                                        <th>H.R.A</th>
                                        <th>E.P.F</th>
                                        <th>Medical</th>
                                        <th>C.A</th>
                                        <th>I.R</th>
                                        <th>R/A</th>
                                        <th>W/A</th>
                                        <th>C/A</th>
                                        <th>Gross</th>
                                        <th>Deductions</th>
                                        <th>Net Pay</th>
                                   </tr>
                                    @foreach($data->months as $mon)
                                        <tr class="month-row" id="{{ $mon['id'] }}_pd">
                                            <td width="120px" class="month">
                                                {{ $mon['name'] }}
                                            </td>
                                            <td width="120px">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="Basic pay" aria-describedby="sizing-addon2" name="bp" required>
                                                </div>
                                            </td>
                                            <td width="80px">
                                                <div class="input-group">
                                                  <input type="text" class="form-control" placeholder="D.A" aria-describedby="sizing-addon2" name="da" value="" data-month="{{$mon['id']}}">
                                                </div>
                                            </td>
                                            <td width="80px">
                                                <div class="input-group">
                                                  <select name="areaType" >
                                                      <option value="0">Rural</option>
                                                      <option value="1">Urban</option>
                                                  </select>
                                                </div>
                                            </td>
                                            <td width="50px" style="text-align: 'right'">
                                                <button type="button" class="btn btn-primary month-action" data-month="{{$mon['id']}}"><i class="fa fa-check" aria-hidden="true"></i></button>
                                            </td>
                                            <td class="total_pay"></td>
                                            <td class="hra"></td>
                                            <td class="epf"></td>
                                            <td class="med"></td>
                                            <td class="city_alw"></td>
                                            <td class="ir"></td>
                                            <td class="ra"></td>
                                            <td class="wa"></td>
                                            <td class="con_alw"></td>
                                            <td class="gross"></td>
                                            <td class="deductions"></td>
                                            <td class="net"></td>
                                        </tr>
                                    @endforeach
                               </table> 
                            </form>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="difference">
                    <!-- <div class="row">
                        <div class="col-md-12"> -->
                            <div class="row">
                        <?php
                            foreach($data->months as $month) { ?>
                                <div class="col-md-3" id="{{ $month['id'] }}_diff">
                                    <div class="card">
                                        <div class="card-header">{{$month['name']}}</div>
                                        <div class="card-body row">
                                            <div class="col-md-12">
                                                <div>Admissable pay: </div>
                                                <div class="col-md-10 col-md-offset-1 diff_ap_np">
                                                    <span class="">Net Pay</span>
                                                    <span class="float-right">N.A</span>
                                                </div>
                                                <div class="col-md-10 col-md-offset-1 diff_ap_de">
                                                    <span class="">Deductions</span>
                                                    <span class="float-right">N.A</span>
                                                </div>    
                                                <div>Pay Drawn: </div>
                                                <div class="col-md-10 col-md-offset-1 diff_pd_np">
                                                    <span class="">Net Pay</span>
                                                    <span class="float-right">N.A</span>
                                                </div>
                                                <div class="col-md-10 col-md-offset-1 diff_pd_de">
                                                    <span class="">Deductions</span>
                                                    <span class="float-right">N.A</span>
                                                </div>  
                                            </div>                                              
                                        </div>
                                        <div class="card-footer"><b>Difference in pay: <span class="float-right">NA</span></b>
                                        </div>
                                    </div>
                                </div>
                        <?php    } ?>
                            </div>
                        
<!--                         </div>
                    </div> -->
                </div>
            </div>

        </div>
    </div>
    
</div>
@endsection