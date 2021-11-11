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


//login  & logout route

    // admin
Route::get('/adminlogin',function(){ 
    return view('admin.admin_login');
});
Route::get('/adminLogout','AdminController@adminLogout');
Route::post('/postAdminLogin', 'AdminController@adminLogin');

    // teacher
Route::get('/teacherLogin',function(){ 
    return view('teacher.teacher_login');
});
Route::get('/teacherLogout','TeacherController@teacherLogout');
Route::post('/postTeacherLogin', 'TeacherController@postTeacherLogin');






// Route for admin

Route::prefix('admin')->group(function () {


    Route::middleware(['admin'])->group(function () {
        // Manager account
        Route::get('/accountSetting','AdminController@adAccountSetting');
        Route::post('/postAccountSetting','AdminController@postAccountSetting');

        // get show
        Route::get('/','AdminController@getDashboard');
        Route::get('/student','AdminController@getStudent');
        Route::get('/teacher','AdminController@getTeacher');
        Route::get('/class','AdminController@getClass');
        Route::get('/exam','AdminController@getExam');
        Route::get('/majors','AdminController@getMajors');
        Route::get('/feedback','AdminController@getFeedback');
        

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
        Route::get('/getEditMajors/{id}','AdminController@getEditMajors');


        // post edit
        Route::post('/postEditStudent/{id}','AdminController@postEditStudent');
        Route::post('/postEditTeacher/{id}','AdminController@postEditTeacher');
        Route::post('/postEditMajors/{id}','AdminController@postEditMajors');
    

        // change status
        Route::get('/changeTeacherStatus/{id}/{status}','AdminController@changeTeacherStatus');
        Route::get('/changeStudentStatus/{id}/{status}','AdminController@changeStudentStatus');
        Route::get('/changeClassStatus/{id}/{status}','AdminController@changeClassStatus');
        Route::get('/changeMajorsStatus/{id}/{status}','AdminController@changeMajorsStatus');

    });
    


    Route::middleware(['adminManager'])->group(function () {
        Route::get('/adminAccount','AdminController@getAdminAccount');
        Route::get('/getAddAdmin','AdminController@getAddAdmin');
        Route::post('/postAddAdmin','AdminController@postAddAdmin');
        Route::get('/getEditAdmin/{id}','AdminController@getEditAdmin');
        Route::post('/postEditAdmin/{id}','AdminController@postEditAdmin');
        Route::get('/changeAdminStatus/{id}/{status}','AdminController@changeAdminStatus');
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

});

// route for teacher
Route::prefix('teacher')->middleware('teacher')->group(function () {
    Route::get('/','TeacherController@getDashboard');

    Route::prefix('class')->group(function () {
        Route::get('/','TeacherController@showClass');
        Route::get('/manager/{id}','TeacherController@getClassManager');
        Route::get('/deleteClassStudent/{class_id}/{student_id}','TeacherController@deleteStudentInClass');
    });

});

