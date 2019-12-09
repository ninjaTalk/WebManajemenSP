<?php

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

Route::get('/', 'AuthController@index');
Route::get('/home', 'TransactionController@index');
Route::get('/selective', 'TransactionController@getSelectiveDate');
Route::resource('transaction', 'TransactionController');

Auth::routes();

//Manage User, Loan, Saving, & Transaction
Route::get('/ManageUser', 'HomeController@manageUser');
Route::resource('employee','EmployeeController');
Route::resource('admins','AdminController');
Route::resource('customer', 'CustomerController');
Route::resource('saving', 'SavingController');
Route::resource('loan', 'LoanController');
Route::get('/lunas', 'LoanController@indexLunas');

//Report Route
Route::get('/menuReport', 'ReportController@menuShow');

//transaction Report
Route::get('/RTransaction', 'ReportController@indexTransaction');
Route::get('/selectiveReport', 'ReportController@getSelectiveDate');
Route::get('/PTransaction', 'ReportController@printTransaction');

//saving Report
Route::get('/RSavings', 'ReportController@indexSaving');
Route::get('/selectiveCollect', 'ReportController@fitlerCollect');
Route::get('/PSavings', 'ReportController@printSavings');

//loan Report
Route::get('/RLoans', 'ReportController@indexLoan');
Route::get('/PLoan', 'ReportController@printLoan');
