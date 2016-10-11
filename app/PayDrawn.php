<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayDrawn extends Model
{
	protected $table = 'pay_drawn';
    protected $fillable = ['emp_id', 'year', 'month', 'basic_pay', 'da', 'total_pay', 'hra', 'hra_amt', 'epf', 'epf_amt', 'med', 'ca', 'ir', 'ra', 'wa', 'gross', 'deductions', 'net_pay', 'area'];
}
