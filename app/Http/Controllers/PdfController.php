<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Salary;
use App\Employee;
use PDF;

class PdfController extends Controller
{       
    public function download_pdf()
    {
        $pdf = PDF::loadView('employee.summary');
        return $pdf->download('summary.pdf');
    }
    
    public function view(Request $request){
        $emp = Employee::find($request->emp_id);
        $data = $emp;
        $year = $request->year;
        $diff = Salary::where("salaries.emp_id", "=", $request->emp_id)
                ->where('salaries.year', '=', $request->year)
                ->join('pay_drawn', 'salaries.month', '=', 'pay_drawn.month')
                ->where('pay_drawn.year', '=', $request->year)
                ->select('salaries.emp_id as emp_id', 'salaries.year', 'salaries.month', 'salaries.net_pay as admissable_pay', 'salaries.deductions as ap_deductions', 'pay_drawn.net_pay as pay_drawn', 'pay_drawn.deductions as pd_deductions')
                ->get();

        $data->salary = $emp->salaryPerYear($request->year);
        $data->pay_drawn = $emp->payDrawnYear($request->year);
        $data->diff = $diff;

        setlocale(LC_MONETARY, 'en_IN');
        $netSalary = $diff->sum('admissable_pay');//money_format(format, number)('%!i', $diff->sum('admissable_pay'));
        $netPayDrawn = $diff->sum('pay_drawn');//money_format('%!i', $diff->sum('pay_drawn'));
        $netIncome = $diff->sum('admissable_pay') - $diff->sum('pay_drawn');
        $data->netSalary = $netSalary; 
        $data->netPayDrawn = $netPayDrawn; 
        $data->netIncome = $netIncome;//money_format('%!i', $netIncome);
        return $data;
    }
}
