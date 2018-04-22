@extends('layouts.app')
@include('/layouts/navigation')
@section('content')
<div class="container create-page">
    <div class="panel panel-default">
        <div class="panel-heading">Add new employee</div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="/images/Jharkhand_Flag.png" alt="logo" class="logo" />
                </div>
                <div class="col-md-6">
                    <form action="/employee/add" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="location" name="location" placeholder="Location">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="designation" placeholder="Designation">
                        </div>
                        <div class="form-group">
                            <!-- <label for="grade-selection">Grade</label> -->
                            <select class="form-control" id="grade-selection" name="grade_selection">
                                <option value="na">Select Grade</option>
                                <option value="manager">Manager</option>
                                <option value="grade_3">Grade 3</option>
                                <option value="grade_4">Grade 4</option>
                            </select>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                    </form>                    
                </div>                    
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-block btn-primary">Next</button>
        </div>
    </div>
</div>
@endsection
