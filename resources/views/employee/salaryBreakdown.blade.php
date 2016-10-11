@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Basic Details</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div><b>Name</b></div>
                        </div>
                        <div class="col-lg-9">{{$data->name}}</div>
                        <div class="col-lg-3">
                            <div><b>Designation</b></div>
                        </div>
                        <div class="col-lg-9">{{$data->designation}}</div>
                        <div class="col-lg-3">
                            <div><b>Location</b></div>
                        </div>
                        <div class="col-lg-9">{{$data->location}}</div>
                        <div class="col-lg-3">
                            <div><b>Email</b></div>
                        </div>
                        <div class="col-lg-9">{{$data->email}}</div>
                        <div class="col-lg-3">
                            <div><b>Area Type</b></div>
                        </div>
                        <div class="col-lg-9">{{$data->areaType}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Salary Breakdown (year wise)</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="emp_id" value="{{$data->id}}">
                            <label for="year_selected_view">Select year</label>
                            <select id="year_selected_view" name="year" class="selectpicker">
                                <option value="na">Select a year</option>
                                <script type="text/javascript">
                                    var dt = new Date();
                                    var yr = dt.getFullYear();
                                    for (var i = 2000; i < yr+1; i++) {
                                        document.write('<option value="'+i+'">'+i+'</option>');
                                    }
                                </script>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <table class="table" id="year_wise_salary">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Basic Pay</th>
                                        <th>DA(%)</th>
                                        <th>Total Pay</th>
                                        <th>H.R.A</th>
                                        <th>E.P.F</th>
                                        <th>Medical</th>
                                        <th>Misc</th>
                                        <th>Gross</th>
                                        <th>Deductions</th>
                                        <th>Net Pay</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    // $(function(){
    //     JSFC.viewSalary();
    // });
</script>