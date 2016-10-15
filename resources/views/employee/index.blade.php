@extends('layouts.app')
@include('/layouts/navigation')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Employees</div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>> 2006</th>
                            <th>< 2006</th>
                        </tr>
                        @foreach($emps as $emp)
                            <tr>
                                <td>
                                    {{ $emp->name }}
                                </td>
                                <td>
                                    <a href="/employee/{{$emp->id}}/salary" class="btn btn-primary">Details</a> 
                                </td>
                                <td>
                                    <!-- <a href="/employee/{{$emp->id}}/salary/add" class="btn btn-primary">Details</a>  -->
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <a href="/employee/create" class="btn btn-primary">Add new employee</a>
        </div>
    </div>
</div>
@endsection
