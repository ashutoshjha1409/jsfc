@extends('layouts.app')
@include('/layouts/navigation')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Basic Details</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="col-lg-3">
                                <div><b>Name:</b></div>
                            </div>
                            <div class="col-lg-9">{{$data->name}}</div>
                            <div class="col-lg-3">
                                <div><b>Designation:</b></div>
                            </div>
                            <div class="col-lg-9">{{$data->designation}}</div>
                            <div class="col-lg-3">
                                <div><b>Location:</b></div>
                            </div>
                            <div class="col-lg-9">{{$data->location}}</div>
                            <div class="col-lg-3">
                                <div><b>Email:</b></div>
                            </div>
                            <div class="col-lg-9">{{$data->email}}</div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <label for="year_selected">Year: &nbsp;</label>                                
                                    </div>
                                </div>
                                <div class="col-lg-6">
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
                                <div class="col-lg-6">
                                    <div><b>Admissable Pay:</b></div>
                                </div>
                                <div class="col-lg-6"><span id="total_admissable_pay">No result</span></div>
                                <div class="col-lg-6">
                                    <div><b>Pay Drawn:</b></div>
                                </div>
                                <div class="col-lg-6"><span id="total_pay_drawn">No result</span></div>
                                <div class="col-lg-6">
                                    <div><b>Net Income:</b></div>
                                </div>
                                <div class="col-lg-6"><span id="net_income">No Result</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="well">
    <div class="row">
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
                                        <th>Gross</th>
                                        <th>Deductions</th>
                                        <th>Net Pay</th>
                                   </tr>
                                    @foreach($data->months as $mon)
                                        <tr class="month-row" id="{{ $mon['id'] }}">
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
                                            <td class="ca"></td>
                                            <td class="gross"></td>
                                            <td class="deductions"></td>
                                            <td class="net"></td>
                                        </tr>
                                    @endforeach
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
