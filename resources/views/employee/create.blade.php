@extends('layouts.app')
@include('/layouts/navigation')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new employee</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            
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
                                        <option value="1">Grade 1</option>
                                        <option value="2">Grade 2</option>
                                        <option value="3">Grade 3</option>
                                        <option value="4">Grade 4</option>
                                    </select>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-block btn-primary">Next</button>
                            </form>                    
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
