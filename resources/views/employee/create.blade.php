@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Add new employee</div>

                <div class="panel-body">
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
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-default">Next</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
