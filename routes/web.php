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

    // student
Route::get('/studentLogin',function(){ 
    return view('student.studentLogin');
});
Route::post('/postStudentLogin', 'StudentController@postStudentLogin');
Route::get('/studentLogout','StudentController@studentLogout');




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

    Route::prefix('historyClass')->group(function () {
        Route::get('/','TeacherController@showHistoryClass');
        
    });

    Route::prefix('exam')->group(function () {
        Route::get('/','TeacherController@showTeacherExamAvalable');
        Route::get('/history','TeacherController@showTeacherExamHistory');
        Route::get('/changeStatus/{id}/on','TeacherController@turnOnExamStatus');
        Route::get('/changeStatus/{id}/off','TeacherController@turnOffExamStatus');
        // add exam 
        Route::get('/addExam','TeacherController@getAddExam');
        Route::post('/postAddExam','TeacherController@postAddExam');
        Route::post('/postEditExam/{id}','TeacherController@postEditExam');
        // manager exam
        Route::get('/getManagerExam/{id}','TeacherController@getManagerExam');
        Route::get('/deleteExam/{id}','TeacherController@deleteExam');

        // post add question &answer exam
        Route::post('/postAddQuestion/{id}','TeacherController@postAddQuestion');
        Route::get('/getEditQuestion/{id}','TeacherController@getEditQuestion');
        Route::post('/postEditQuestion/{id}','TeacherController@postEditQuestion');


        Route::get('/deleteQuestion/{id}','TeacherController@deleteQuestion');
    });

});


// route for student
Route::prefix('student')->middleware('student')->group(function () {
    Route::get('/','StudentController@getDashboard');
    Route::get('/exam','StudentController@getExam');

    Route::get('/historyExam','StudentController@historyExam');
    Route::get('/class','StudentController@getClass');
    Route::get('/viewClass/{id}','StudentController@getViewClass');

    Route::get('/historyClass','StudentController@historyClass');
    Route::get('/doExam/{id}','StudentController@checkTimeToDoExam');
    Route::get('/feedback','StudentController@getFeedback');

    Route::post('/submitExam/{id}','StudentController@postSubmitExam');

    Route::get('/resultDetal/{id}','StudentController@resultDetail');
    Route::get('/accSetting','StudentController@accSetting');
    Route::post('/postExamFeedback','StudentController@postExamFeedback');

    


});
// test
Route::get('/check','StudentController@check');


// forgetPassword
Route::get('/studentForgetPassword',function(){
    return view('student.forgetPassword');
});
Route::post('/postStudentFP','StudentController@postStudentFP');
Route::get('/resetpwEmailConfirmStu/{id}/{token}','StudentController@resetpwEmailConfirmStu');
