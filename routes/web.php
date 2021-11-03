<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/adminlogin',function(){ 
    return view('admin.admin_login');
});
Route::post('/postLogin', 'AdminController@adminLogin')->name('postLogin');



Route::prefix('admin')->group(function () {
    // get show
    Route::get('/','AdminController@getDashboard');
    Route::get('/student','AdminController@getStudent');
    Route::get('/teacher','AdminController@getTeacher');
    Route::get('/class','AdminController@getClass');
    Route::get('/exam','AdminController@getExam');
    Route::get('/majors','AdminController@getMajors');
    Route::get('/feedback','AdminController@getFeedback');
    Route::get('/adminAccount','AdminController@getAdminAccount');

    // get add
    Route::get('/getAddStudent','AdminController@getAddStudent');
    Route::get('/getAddTeacher','AdminController@getAddTeacher');
    Route::get('/getAddMajors',function(){
        return view('admin.addMajors');
    });

    // post add
    Route::post('/postAddStudent','AdminController@postAddStudent');
    Route::post('/postAddTeacher','AdminController@postAddTeacher');
    Route::post('/postAddMajors','AdminController@postAddMajors');

    // get edit
    Route::get('/getEditStudent/{id}','AdminController@getEditStudent');
    Route::get('/getEditTeacher/{id}','AdminController@getEditTeacher');

    // post edit
    Route::post('/postEditStudent/{id}','AdminController@postEditStudent');
    Route::post('/postEditTeacher/{id}','AdminController@postEditTeacher');

    // change status
    Route::get('/changeTeacherStatus/{id}/{status}','AdminController@changeTeacherStatus');
    Route::get('/changeStudentStatus/{id}/{status}','AdminController@changeStudentStatus');
    Route::get('/changeAdminStatus/{id}/{status}','AdminController@changeAdminStatus');
    Route::get('/changeClassStatus/{id}/{status}','AdminController@changeClassStatus');
    Route::get('/changeMajorsStatus/{id}/{status}','AdminController@changeMajorsStatus');
});

