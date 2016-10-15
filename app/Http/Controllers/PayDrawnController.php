<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PayDrawn;

class PayDrawnController extends Controller
{
    public function store(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $empId = $request->emp_id;
        $areaType = $request->area_type;        
        $bp = $request->basic_pay;        
        $da = $request->da;  
        $date = strtotime($year.'-'.$month);  

        $sal = PayDrawn::where('emp_id', $empId)
                ->where('year', $year)
                ->where('month', $month)
                ->first();   
        
        $hra = 0;
        $hraAmt = 0;
        $area = true;        
        $totalPay = round($bp + ($da * $bp)/100);
        $epf = 12;
        $med = 100;
        $cityAlw = 0;
        $conAlw = 0;
        $ir = 0;
        $ra = 0;
        $wa = 0;

        // CALCULATE H.R.A
        if ($areaType == 0) {
            $hra = 7;
            $hraAmt = ($hra * $bp)/100;
            $area = false;
        } else {
            $hra = 15;
            $hraAmt = ($hra * $bp)/100;
        }

        // CALCULATE E.P.F
        $epfAmt = round(($epf * $totalPay)/100);

        // CITY & CONVENINCE ALLOWANCE
        $sep07 = strtotime("2007-09");
        $apr10 = strtotime("2010-04");
        if ($date <= $apr10 && $date >= $sep07){
            $cityAlw = 120;
            $conAlw = 75;
        } 


        $gross = $totalPay + round($hraAmt) + $epfAmt + $med + $cityAlw + $ir + $ra + $wa + $conAlw;

        $deductions = round($epfAmt * 2);
        $net = round($gross - $deductions);

        if ($sal) {
            $sal->basic_pay = $bp;
            $sal->da = $da;
            $sal->area = $area;
            $sal->total_pay = $totalPay;
            $sal->hra_amt = $hraAmt;
            $sal->epf_amt = $epfAmt;
            $sal->city_alw = $cityAlw;
            $sal->con_alw = $conAlw;
            $sal->gross = $gross;
            $sal->deductions = $deductions;
            $sal->net_pay = $net;
            $sal->save();
        } else {
            $sal = PayDrawn::create([
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
                'city_alw' => $cityAlw,
                'con_alw' => $conAlw,
                'ir' => $ir,
                'ra' => $ra,
                'wa' => $wa,
                'gross' => $gross,
                'deductions' => $deductions,
                'net_pay' => $net
            ]);
        }
        
        return $sal;        
    }
}
