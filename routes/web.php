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
Route::get('/adminlogin','AdminController@getAdLogin');
Route::get('/adminLogout','AdminController@adminLogout');
Route::post('/postAdminLogin', 'AdminController@adminLogin');

    // teacher
Route::get('/teacherLogin','TeacherController@getTeacherLogin');
Route::get('/teacherLogout','TeacherController@teacherLogout');
Route::post('/postTeacherLogin', 'TeacherController@postTeacherLogin');

    // student
Route::get('/studentLogin','StudentController@getStudentLogin');
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
        Route::get('/managerClass/{id}','AdminController@getManagerClass');
        Route::get('/classExamResult/{id}','AdminController@classExamResult');
        Route::get('/showExamQuestion/{id}','AdminController@showExamQuestion');
        Route::get('/studentExamResultDetail/{studentId}&{examId}','AdminController@studentExamResultDetail');
        

        // get add
        Route::get('/getAddStudent','AdminController@getAddStudent');
        Route::get('/getAddTeacher','AdminController@getAddTeacher');
        Route::get('/getAddMajors',function(){
            return view('admin.addMajors');
        });
        Route::get('/getAddClass','AdminController@getAddClass');
        

        // post add
        Route::post('/postAddStudent','AdminController@postAddStudent');
        Route::post('/postAddTeacher','AdminController@postAddTeacher');
        Route::post('/postAddMajors','AdminController@postAddMajors');
        Route::post('/postAddClass','AdminController@postAddClass');
        Route::post('/class/addStudent/{id}','AdminController@postClassAddStudent');

    

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
        Route::get('/changeFeedbackStatus/{id}/{status}','AdminController@changeFeedbackStatus');

        // delete
        Route::get('/deleteClass/{id}','AdminController@deleteClass');
        Route::get('/deleteClassStudent/{class_id}/{student_id}','AdminController@deleteStudentInClass');

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
        Route::get('/showExamQuestionADM/{id}','AdminController@showExamQuestionADM');
    });    

});

// route for teacher
Route::prefix('teacher')->middleware('teacher')->group(function () {
    Route::get('/','TeacherController@getDashboard');
    Route::get('/info','TeacherController@teacherInfo');

    Route::prefix('class')->group(function () {
        Route::get('/','TeacherController@showClass');
        Route::get('/manager/{id}','TeacherController@getClassManager');
        Route::get('/deleteClassStudent/{class_id}/{student_id}','TeacherController@deleteStudentInClass');
    });

    Route::prefix('historyClass')->group(function () {
        Route::get('/','TeacherController@showHistoryClass');
        Route::get('/manager/{id}','TeacherController@getHistoryClassManager');
        
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

        // view class exam result
        Route::get('/classExamResult/{id}','TeacherController@classExamResult');
        Route::get('/studentExamResultDetail/{studentId}&{examId}','TeacherController@studentExamResultDetail');

    });

    Route::prefix('feedback')->group(function () {
        Route::get('/','TeacherController@showFeedback');
        Route::post('/repFeedback/{id}','TeacherController@repFeedback');
    });

});


// route for student
Route::prefix('student')->middleware('student')->group(function () {
    Route::get('/','StudentController@getDashboard');
    Route::get('/exam','StudentController@getExam');

    Route::get('/historyExam','StudentController@historyExam');
    Route::get('/class','StudentController@getClass');
    Route::get('/viewClass/{id}','StudentController@getViewClass');

    // Route::get('/historyClass','StudentController@historyClass');
    Route::get('/checkDoExam/{id}','StudentController@checkTimeToDoExam');
    Route::get('/feedback','StudentController@getFeedback');
    Route::get('/doExam/{id}','StudentController@doExam');

    Route::post('/submitExam/{id}','StudentController@postSubmitExam');

    Route::get('/resultDetail/{id}','StudentController@resultDetail');
    Route::get('/accSetting','StudentController@accSetting');
    Route::post('/postManagerAccount','StudentController@postManagerAccount');

    Route::post('/postExamFeedback','StudentController@postExamFeedback');

});
// test
Route::get('/check','StudentController@check');


// student forgetPassword
Route::get('/studentForgetPassword',function(){
    return view('student.forgetPassword');
});
Route::post('/postStudentFP','StudentController@postStudentFP');
Route::get('/resetpwEmailConfirmStu/{id}/{token}','StudentController@resetpwEmailConfirmStu');
Route::post('/pNewPassword','StudentController@pNewPassword');
// student exam