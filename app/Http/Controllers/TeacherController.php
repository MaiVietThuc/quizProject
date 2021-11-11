<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function postTeacherLogin(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|',
            'password' => 'required|min:6',
        ]);
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
          
        if (Auth::guard('teacher')->attempt($arr)) {
            return redirect('/teacher/')->with('success','Chào mừng '.Auth::guard('teacher')->user()->name.'!!');
        } else {
            return redirect('/teacherLogin')->with('error', 'Thông tin đăng nhập không chính xác!!'); 
        }
    }
    public function teacherLogout()
    {
        Auth::guard('teacher')->logout();
        return redirect('/teacherLogin');
    }



    // get show
    public function getDashboard()
    {
        $currTeacher = App\teacher::with(['subject'])->find(Auth::guard('teacher')->id());
        return view('teacher.dashboard')->with('currTeacher',$currTeacher);
    }
    public function showClass()
    {
        $now = date('Y-m-d');
        $teachClass =App\cclass::where('teacher_id','=',(Auth::guard('teacher')->id()))->where('date_close','>=',$now)->get();
        return view('teacher.class')->with('teachClass',$teachClass)->with('now',$now);
    }

    public function getClassManager($id)
    {
        $classinf = App\cclass::with(['student'])->find($id);
        $exam_test = App\exam::where('class_id','=',$id)->where('type','exam_test')->count();
        $tested_exam = App\exam::where('class_id','=',$id)->where('type','exam')->where('time_close','<',Carbon::now())->count();
        $untested_exam = App\exam::where('class_id','=',$id)->where('type','exam')->where('time_open','>',Carbon::now())->count();
        return view('teacher.classManager')->with('classinf',$classinf)->with('exam_test',$exam_test)->with('tested_exam',$tested_exam)->with('untested_exam',$untested_exam);
    }

    // delete student from class
    public function deleteStudentInClass($class_id, $student_id)
    {
        $class = App\cclass::find($class_id);
        $class->student()->detach($student_id);
        return redirect('teacher/class/manager/'.$class_id.'')->with('success','Xóa thành công!');
    }
    
}
