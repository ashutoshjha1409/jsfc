<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Salary;
use App\Employee;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $empId = $request->emp_id;
        $areaType = $request->area_type;        
        $bp = $request->basic_pay;        
        $da = $request->da;    

        $sal = Salary::where('emp_id', $empId)
                        ->where('year', $year)
                        ->where('month', $month)
                        ->first();   

        
        $hra = 0;
        $hraAmt = 0;
        $area = true;        
        $totalPay = $bp + ($da * $bp)/100;
        $epf = 12;
        $med = 300;
        $misc = 0;
        // CALCULATE H.R.A
        if ($areaType == 0) {
            $hra = 10;
            $hraAmt = ($hra * $bp)/100;
            $area = false;
        } else {
            $hra = 20;
            $hraAmt = ($hra * $bp)/100;
        }

        // CALCULATE E.P.F
        $epfAmt = ($epf * $totalPay)/100;

        $gross = $totalPay + $hraAmt + $epfAmt + $med + $misc;

        $deductions = $epfAmt * 2;
        $net = $gross - $deductions;

        if ($sal) {
            $sal->basic_pay = $bp;
            $sal->da = $da;
            $sal->area = $area;
            $sal->total_pay = $totalPay;
            $sal->hra_amt = $hraAmt;
            $sal->epf_amt = $epfAmt;
            $sal->gross = $gross;
            $sal->deductions = $deductions;
            $sal->net_pay = $net;
            $sal->save();
        } else {
            $sal = Salary::create([
                'emp_id' => $empId,
                'year' => $year,
                'month' => $month,
                'basic_pay' => $bp,
                'da' => $da,
                'area' => $area,
                'total_pay' => $totalPay,
                'hra' => $hra,
                'hra_amt' => $hraAmt,
                'epf' => $epf,
                'epf_amt' => $epfAmt,
                'med' => $med,
                'misc' => $misc,
                'gross' => $gross,
                'deductions' => $deductions,
                'net_pay' => $net
            ]);
        }
        
        return $sal;        
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function view(Request $request){
        $emp = Employee::find($request->emp_id);
        $data = $emp;
        $year = $request->year;
        $diff = Salary::where("salaries.emp_id", "=", $request->emp_id)
                ->where('salaries.year', '=', $request->year)
                ->join('pay_drawn', 'salaries.month', '=', 'pay_drawn.month')
                ->select('salaries.emp_id as emp_id', 'salaries.year', 'salaries.month', 'salaries.net_pay as admissable_pay', 'pay_drawn.net_pay as pay_drawn')
                ->get();

        $data->salary = $emp->salaryPerYear($request->year);
        $data->pay_drawn = $emp->payDrawnYear($request->year);
        $data->diff = $diff;

        setlocale(LC_MONETARY, 'en_IN');
        $netSalary = money_format('%!i', $diff->sum('admissable_pay'));
        $netPayDrawn = money_format('%!i', $diff->sum('pay_drawn'));
        $netIncome = $diff->sum('admissable_pay') - $diff->sum('pay_drawn');
        $data->netSalary = $netSalary; 
        $data->netPayDrawn = $netPayDrawn; 
        $data->netIncome = money_format('%!i', $netIncome);
        return $data;
    }
}
