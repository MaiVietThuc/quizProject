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
    Route::get('/getAddAdmin','AdminController@getAddAdmin');

    // post add
    Route::post('/postAddStudent','AdminController@postAddStudent');
    Route::post('/postAddTeacher','AdminController@postAddTeacher');
    Route::post('/postAddMajors','AdminController@postAddMajors');
    Route::post('/postAddAdmin','AdminController@postAddAdmin');

    // get edit
    Route::get('/getEditStudent/{id}','AdminController@getEditStudent');
    Route::get('/getEditTeacher/{id}','AdminController@getEditTeacher');
    Route::get('/getEditMajors/{id}','AdminController@getEditMajors');
    Route::get('/getEditAdmin/{id}','AdminController@getEditAdmin');

    // post edit
    Route::post('/postEditStudent/{id}','AdminController@postEditStudent');
    Route::post('/postEditTeacher/{id}','AdminController@postEditTeacher');
    Route::post('/postEditMajors/{id}','AdminController@postEditMajors');
    Route::post('/postEditAdmin/{id}','AdminController@postEditAdmin');

    // change status
    Route::get('/changeTeacherStatus/{id}/{status}','AdminController@changeTeacherStatus');
    Route::get('/changeStudentStatus/{id}/{status}','AdminController@changeStudentStatus');
    Route::get('/changeAdminStatus/{id}/{status}','AdminController@changeAdminStatus');
    Route::get('/changeClassStatus/{id}/{status}','AdminController@changeClassStatus');
    Route::get('/changeMajorsStatus/{id}/{status}','AdminController@changeMajorsStatus');

    // delete
    Route::prefix('delete')->group(function(){
        Route::get('/teacher/{id}','AdminController@deleteTeacher');
        Route::get('/student/{id}','AdminController@deleteStudent');
        Route::get('/admin/{id}','AdminController@deleteAdmin');
        Route::get('/majors/{id}','AdminController@deleteMajors');
        Route::get('/class/{id}','AdminController@deleteClass');
        Route::get('/feedback/{id}','AdminController@deleteFeedback');
    });
    
});

