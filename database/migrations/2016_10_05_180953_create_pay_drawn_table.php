<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayDrawnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_drawn', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emp_id');
            $table->integer('year');
            $table->string('month');
            $table->boolean('area');
            $table->double('basic_pay', 15, 2);
            $table->double('da', 15, 2);
            $table->double('total_pay', 15, 2);
            $table->double('hra', 15, 2);
            $table->double('hra_amt', 15, 2);
            $table->double('epf', 15, 2);
            $table->double('epf_amt', 15, 2);
            $table->double('med', 15, 2);
            $table->double('city_alw', 15, 2);
            $table->double('con_alw', 15, 2);
            $table->double('ir', 15, 2);
            $table->double('ra', 15, 2);
            $table->double('wa', 15, 2);
            $table->double('gross', 15, 2);
            $table->double('deductions', 15, 2);
            $table->double('net_pay', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pay_drawn');
    }
}
