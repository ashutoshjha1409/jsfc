<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'email', 'location', 'designation'];

    public function salary()
    {
        return $this->hasMany('App\Salary', 'emp_id');
    }

    public function payDrawn()
    {
        return $this->hasMany('App\PayDrawn', 'emp_id');
    }

    public function salaryPerYear($year){
    	$salary = $this->salary()->where("year", $year)->get();
    	return $salary;
    }

    public function payDrawnYear($year){
    	$salary = $this->payDrawn()->where("year", $year)->get();
    	return $salary;
    }

    public function netSalaryPerYear($year){
    	$salary = $this->salary()->where("year", $year)->select('net_pay')->get();
    	$sum = $salary->sum('net_pay');
    	return $sum;
    }

    public function netPayDrawnPerYear($year){
    	$salary = $this->payDrawn()->where("year", $year)->select('net_pay')->get();
    	$sum = $salary->sum('net_pay');
    	return $sum;
    }
}
