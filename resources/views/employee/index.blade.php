@extends('layouts.app')
@include('/layouts/navigation')
@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Employees</div>

        <div class="panel-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>After 2006</th>
                        <th>Before 2006</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emps as $emp)
                        <tr>
                            <td class="capitalize ellipsis">
                                {{ $emp->name }}
                            </td>
                            <td>
                                <a href="/employee/{{$emp->id}}/salary" class="btn">Details</a> 
                            </td>
                            <td>
                                <!-- <a href="/employee/{{$emp->id}}/salary/add" class="btn btn-primary">Details</a>  -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <a href="{{ url('/employee/create') }}" class="btn btn-primary">Add new employee</a>
        </div>
    </div>  
</div>
@endsection
