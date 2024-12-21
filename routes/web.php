<?php

use App\Http\Controllers\EmployeeChartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('EmployeeChart', [EmployeeChartController::class, 'getPeriod']);
//});

Route::controller(EmployeeChartController::class)->group(function () {
    Route::get('/', 'index');
    Route::get("/get-period", 'getPeriod')->name('getPeriod');
    Route::get('/getEmployeeCount', 'getEmployeeCount')->name('getEmployeeCount');
});



