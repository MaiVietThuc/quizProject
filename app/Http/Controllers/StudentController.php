<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function postStudentLogin(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|',
            'password' => 'required|min:6',
        ]);
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
          
        if (Auth::guard('student')->attempt($arr)) {
            return redirect('/student/')->with('success','Chào mừng '.Auth::guard('student')->user()->name.'!!');
        } else {
            return redirect()->back()->with('error', 'Thông tin đăng nhập không chính xác!!'); 
        }
    }
    public function studentLogout()
    {
        Auth::guard('student')->logout();
        return redirect('/');
    }

    public function getDashboard()
    {
        $currStudentId = Auth::guard('student')->id();
        $student = App\student::with(['cclass'])->find($currStudentId);
        $classId = array(); 
        foreach($student->cclass as $val){
            $classId[]=$val->id;
        }
        $exam = App\exam::whereIn('class_id',$classId);
        $feedback = App\feedback::where('student_id',$currStudentId);
        $examFeedback = App\exam_feedback::where('student_id',$currStudentId);
        $feedbackAll = $feedback->count() + $examFeedback->count();
        return view('student.dashboard',compact('student','exam','feedback','examFeedback','feedbackAll'));
    }

    public function getExam()
    {
        $currStudentId = Auth::guard('student')->id();
        $student = App\student::select('id')->with('cclass')->find($currStudentId);
        $classId = array(); 
        foreach($student->cclass as $val){
            $classId[]=$val->id;
        }
        $usedExamId = App\exam_student_status::select('exam_id')->where('student_id',$currStudentId)->get(); //exam that student tested
        $exams = App\exam::whereIn('class_id',$classId)->whereNotIn('id',$usedExamId)->where('time_close','>',Carbon::now())->orWhere('type','=','exam_test')->get();
        return view('student.exam')->with('exams',$exams);
    }

    public function historyExam()
    {
        $currStudentId = Auth::guard('student')->id();
        $usedExamId = App\exam_student_status::select('exam_id')->where('student_id',$currStudentId)->get(); //exam that student tested
        $exams = App\exam::whereIn('id',$usedExamId)->get();
        return view('student.historyExam')->with('exams',$exams);
    }

    public function getClass()
    {
        $classid = App\class_student::select('class_id')->where('student_id',Auth::guard('student')->id())->get()->toArray();
        $class = App\cclass::whereIn('id',$classid)->where('date_close','>=',Carbon::now())->where('status',1)->get();
        return view('student.class')->with('class',$class);
    }

    public function historyClass()
    {
        $classid = App\class_student::select('class_id')->where('student_id',Auth::guard('student')->id())->get()->toArray();
        $class = App\cclass::whereIn('id',$classid)->where('date_close','<',Carbon::now())->where('status',1)->get();
        return view('student.historyClass')->with('class',$class);
    }

    public function checkTimeToDoExam($id)
    {
        $exam = App\exam::find($id);
       

        $openTime = Carbon::parse($exam->time_open)->format('Y/m/d H:i:s');
        $timeCoutDown = Carbon::now()->diffInSeconds($openTime);
        // $tt = gmdate('d H:i:s', $timeCoutDown);
        if($timeCoutDown >10 )
        {
            return view('student.countDownExam',compact('timeCoutDown','exam'));
        }
        if($timeCoutDown<10)
        {
            return redirect('/student/doExam/'.$id.'');
        }
    }
}
