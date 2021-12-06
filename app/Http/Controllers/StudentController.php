<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Mail;

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
            return redirect('/student/')->with('success','Chào mừng '.Auth::guard('student')->user()->name.'!!')->with('email',$request->email)->with('password',$request->password);
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
        $usedExam = App\exam_student_status::where('student_id',$currStudentId)->get(); //exam that student tested
        $usedExamId = array();
        foreach($usedExam as $e){
            $usedExamId[]=$e->exam_id;
        }
        $exams = App\exam::whereIn('class_id',$classId)->where('status',1)->whereNotIn('id',$usedExamId)->where(function($query) {
            return $query
                   ->where('time_close','>',Carbon::now())
                   ->orWhere('type','=','exam_test');
           })->get();

        return view('student.exam')->with('exams',$exams);
    }

    public function historyExam()
    {
        $currStudentId = Auth::guard('student')->id();
        $usedExam = App\exam_student_status::where('student_id',$currStudentId)->with('exam')->get(); //exam that student tested
        // $exams = App\exam::whereIn('id',$usedExamId)->with('exam_student_status')->get();
        return view('student.historyExam')->with('exams',$usedExam);
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
        $closeTime = Carbon::parse($exam->timme_close)->format('Y/m/d H:i:s');
        $timeCoutDown = Carbon::now()->diffInSeconds($openTime);
         
        $checkExamStatus = App\exam_student_status::where('exam_id',$id)->where('student_id',Auth::guard('student')->id())->count();
        if($checkExamStatus ==0)
        {
            if($timeCoutDown >10 )
            {
                return view('student.countDownExam',compact('timeCoutDown','exam'));
            }
            elseif($timeCoutDown<10 || $timeCoutDown=0)
            { 
                return view('student.doExam')->with('exam',$exam)->with('success',"Bắt đầu làm bài!");
            }
            elseif($timeCoutDown <0)
            {
                $remainingTime = Carbon::now()->diffInSeconds($closeTime);
                return view('student.doExam')->with('exam',$exam)->with('remainingTime',$remainingTime)->with('error',"Bạn đã vào thi trễ!");
            }
        }
        else
        {
            return redirect()->back()->with('error','Bạn đã làm bài kiểm tra này rồi!');
        }
    }


    public function getViewClass($id)
    {
        $classinf = App\cclass::find($id);
        return view('student.classview')->with('classinf',$classinf);
    }

    public function postSubmitExam(Request $request, $id)
    {
        $checkExamStatus = App\exam_student_status::where('exam_id',$id)->where('student_id',Auth::guard('student')->id())->count();
        if($checkExamStatus ==0)
        {
            $exam = App\exam::find($id);
            $qu = $exam->question;
            $currStudent = Auth::guard('student')->id();
            $mark=0;
            $true_ans=0;
            foreach($qu as $q)
            {
                // insert in table student_answer
                $studentAnswer = new App\student_answer;
                $studentAnswer->student_id = $currStudent;
                $studentAnswer->exam_id = $id;
                $studentAnswer->question_id = $q->id;
                $studentAnswer->user_answer_option = $request->input('question_'.$q->id);
                $studentAnswer->save();

                if ($request->input('question_'.$q->id) == $q->corr_ans)
                {
                    $mark += ($q->mark);
                    $true_ans +=1;
                }         
            }
            // insert student_exam status
            $exam_student_status = new App\exam_student_status;
            $exam_student_status->exam_id = $id;
            $exam_student_status->student_id = $currStudent;
            $exam_student_status->status = 'used';
            $exam_student_status->mark = $mark;
            $exam_student_status->time_start = Carbon::parse($request->time_start)->format('Y-m-d H:i:s');
            $exam_student_status->time_end = Carbon::now()->format('Y-m-d H:i:s');
            $exam_student_status->save();

            return view('student.resultAfterExam')->with('exam',$exam)->with('true_ans',$true_ans)->with('e_s_status',$exam_student_status);
        }else{
            return redirect()->back()->with('error','Bạn đã làm bài kiểm tra này rồi!');
        }
    }

    public function resultDetail($id)
    {
        $currStudent = Auth::guard('student')->id();
        $stStudentExam = App\exam_student_status::find($id);
        $exam_info = App\exam::find($stStudentExam->exam_id);
        $studentAnswer = App\student_answer::where('exam_id',$stStudentExam->exam_id)->where('student_id',$currStudent)->with('question')->get();
        return view('student.resultDetail')->with('stStudentExam',$stStudentExam)->with('studentAnswer',$studentAnswer)->with('exam_info',$exam_info);
    }

    public function accSetting()
    {
        $currStudent = Auth::guard('student')->id();
        $you = App\student::find($currStudent);
        return view('student.account')->with('you',$you);
    }
    
    public function getFeedback()
    {
        $examfeedBack = App\exam_feedback::where('student_id',Auth::guard('student')->id())->get();
        return view('student.feedback')->with('examfeedBack',$examfeedBack);
        // print_r($examfeedBack);
    }

    public function postExamFeedback(Request $request)
    {
        $exFeedback = new App\exam_feedback;
        $exFeedback->exam_id = $request->exam_id;
        $exFeedback->student_id = Auth::guard('student')->id();
        $exFeedback->student_feedback = $request->feedback_content;
        $exFeedback->save();
        return redirect('/student/historyExam')->with('success','Gửi thành công!!'); 
    }

    // test
    public function check()
    {
        return view('mailForgetPassword');
    }

    // forgetPassword
    public function postStudentFP(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|min:4',
            'mssv' => 'required|min:3',
        ]);
        $student = App\student::where ('email', $request->email)->where('student_code',$request->mssv)->first();
        if(!$student)
        {
            return redirect()->back()->with('error','Thông tin nhập vào sai')->with('email',$request->email)->with('mssv',$request->mssv);
        }
        //create a token
        $student->remember_token = Str::random(60);
        $student->save();

        Mail::send('mailForgetPassword', ['token'=>$student->remenber_token,'student_name'=>$student->name,'student_id'=>$student->id], function ($message)use($request) {
            $message->to($request->email);
            $message->subject('Đặt lại mật khẩu');
        });
        return redirect()->back()->with('success','đã gửi!');
    }

    public function resetpwEmailConfirmStu($id, $token)
    {
        $student = App\student::where('id',$id)->where('remember_token',$token)->first();
        if(!$student)
        {
            return abort(404,'Page not found');
        }
        
    }
}
