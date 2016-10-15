<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = ['emp_id', 'year', 'month', 'basic_pay', 'da', 'total_pay', 'hra', 'hra_amt', 'epf', 'epf_amt', 'med', 'ca', 'gross', 'deductions', 'net_pay', 'area'];
}
