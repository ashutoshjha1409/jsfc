<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emps = Employee::all();
        return view('employee.index', compact('emps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->name || !$request->email){
            return "false";
        }

        if ($request->grade_selection == "na"){
            return "false";
        }

        $data = Employee::create(['name' => $request->name, 'email' => $request->email, 'location' => $request->location, 'designation' => $request->designation, 'grade' => (int)$request->grade_selection]);

        $url = '/employee/'.$data->id.'/salary/add';

        return redirect($url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function addSalary(Request $request, $id){
        $data = $this->constructData($id);
        return view('employee.addSalary', compact('data'));
    }

    public function viewSalary(Request $request, $id){
        $data = $this->constructData($id);
        return view('employee.salaryBreakdown', compact('data'));
    }

    public function constructData($id){
        $data = Employee::find($id);
        
        if ($data->area == 0){
            $data->hra = '10%';
        } else {
            $data->hra = '20%';
        }

        $data->epf = '12%';

        $data->months = [['name' => 'January', 'code' => 'jan', 'id' => 1], 
            ['name' => 'Feburary', 'code' => 'feb', 'id' => 2], 
            ['name' => 'March', 'code' => 'mar', 'id' => 3], 
            ['name' => 'April', 'code' => 'apr', 'id' => 4], 
            ['name' => 'May', 'code' => 'may', 'id' => 5], 
            ['name' => 'June', 'code' => 'jun', 'id' => 6], 
            ['name' => 'July', 'code' => 'jul', 'id' => 7], 
            ['name' => 'August', 'code' => 'aug', 'id' => 8], 
            ['name' => 'September', 'code' => 'sep', 'id' => 9], 
            ['name' => 'October', 'code' => 'oct', 'id' => 10], 
            ['name' => 'November', 'code' => 'nov', 'id' => 11], 
            ['name' => 'December', 'code' => 'dec', 'id' => 12]
            ];

        return $data;
    }

    public function getDifference(Request $request){
        $emp = Employee::find($request->emp_id);
        $salary = $emp->salary;

        var_dump($request->emp_id);
        return $salary;
    }
}
