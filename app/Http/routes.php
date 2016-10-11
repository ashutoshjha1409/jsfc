<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'EmployeeController@index');
Route::get('employee/create', 'EmployeeController@create');
Route::get('employee/{id}/salary/add', 'EmployeeController@addSalary');
/*Route::get('employee/{id}/salary/view', 'EmployeeController@viewSalary');*/
Route::post('employee/add', 'EmployeeController@store');
Route::post('salary/add', 'SalaryController@store');
Route::get('salary/view', 'SalaryController@view');
Route::post('paydrawn/add', 'PayDrawnController@store');

Route::auth();

