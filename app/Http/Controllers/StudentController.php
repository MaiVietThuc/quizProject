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
use Illuminate\Support\Facades\File; 

class StudentController extends Controller
{
    public function getStudentLogin()
    {
        if(Auth::guard('student')->check())
        {
            return redirect('/student');
        }
        else
        {
            return view('student.studentLogin');
        }
    }

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
            return redirect('/student')->with('success','Chào mừng '.Auth::guard('student')->user()->name.'!!')->with('email',$request->email)->with('password',$request->password);
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
        $student = App\student::select('id')->with('cclass')->find($currStudentId);

        // get Ready exam
        $classId = array(); 
        foreach($student->cclass as $val){
            if($val->date_close < Carbon::now())
            {
                continue;
            }else{
                $classId[]=$val->id;
            }
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
           })->count();

        // get history exam & average mark
        $usdExam = App\exam_student_status::where('student_id',$currStudentId);
        $usedExam = $usdExam->count();
        $avgMark = $usdExam->avg('mark');

        // get class
        $allclassid = App\class_student::select('class_id')->where('student_id',Auth::guard('student')->id())->get()->toArray();
        $class = App\cclass::whereIn('id',$allclassid)->where('date_close','>=',Carbon::now())->where('status',1)->count();
        $history_class = App\cclass::whereIn('id',$allclassid)->where('date_close','<',Carbon::now())->where('status',1)->count();
        $allClass = $class + $history_class;

        // get examFeedback
        $examFeedBack = App\exam_feedback::where('student_id',$currStudentId)->count();

        return view('student.dashboard',compact('student','exams','usedExam','avgMark','allClass','examFeedBack'));
    }

    public function getExam()
    {
        $currStudentId = Auth::guard('student')->id();
        $student = App\student::select('id')->with('cclass')->find($currStudentId);
        $classId = array(); 
        foreach($student->cclass as $val){
            if($val->date_close < Carbon::now())
            {
                continue;
            }else{
                $classId[]=$val->id;
            }
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
        $classid = App\class_student::select('class_id')->where('student_id',Auth::guard('student')->id())->where('status',1)->get()->toArray();
        $class = App\cclass::whereIn('id',$classid)->where('date_close','>=',Carbon::now())->where('status',1)->get();
        $history_class = App\cclass::whereIn('id',$classid)->where('date_close','<',Carbon::now())->where('status',1)->get();
        return view('student.class')->with('class',$class)->with('history_class',$history_class);
    }

    // public function historyClass()
    // {
    //     $classid = App\class_student::select('class_id')->where('student_id',Auth::guard('student')->id())->get()->toArray();
    //     $class = App\cclass::whereIn('id',$classid)->where('date_close','<',Carbon::now())->where('status',1)->get();
    //     return view('student.historyClass')->with('class',$class);
    // }

    
    public function getViewClass($id)
    {
        $classinf = App\cclass::find($id);
        return view('student.classview')->with('classinf',$classinf);
    }


    public function checkTimeToDoExam($id)
    {
        $exam = App\exam::find($id);
        $openTime = Carbon::parse($exam->time_open)->format('Y/m/d H:i:s');
        $closeTime = Carbon::parse($exam->time_close)->format('Y/m/d H:i:s');

        $checkExamStatus = App\exam_student_status::where('exam_id',$id)->where('student_id',Auth::guard('student')->id())->count();
        $timeCoutDown = Carbon::now()->diffInSeconds($openTime);
        if($checkExamStatus ==0)
        {
            if(!is_null($exam->time_close) && Carbon::parse($exam->time_close) <= Carbon::now())
            {
                return redirect('student/exam')->with('error','Bài thi đã kết thúc!!');
            }
            elseif($timeCoutDown <= 5 || (Carbon::parse($exam->time_open) <= Carbon::now() && Carbon::parse($exam->time_close) > Carbon::now()))
            {
                return view('student.confirmDoExam')->with('exam',$exam);
            }
            elseif(Carbon::parse($exam->time_open) > Carbon::now() && $timeCoutDown > 5)
            { 
                return view('student.countDownExam',compact('timeCoutDown','exam'));
            }
        }
        else
        {
            return redirect('student/exam')->with('error','Bạn đã làm bài kiểm tra này rồi!');
        }
        
    }

    public function doExam($id)
    {
        $exam = App\exam::find($id);
        $openTime = Carbon::parse($exam->time_open)->format('Y/m/d H:i:s');
        $closeTime = Carbon::parse($exam->time_close)->format('Y/m/d H:i:s');
        
        $checkExamStatus = App\exam_student_status::where('exam_id',$id)->where('student_id',Auth::guard('student')->id())->count();
        $timeCoutDown = Carbon::now()->diffInSeconds($openTime);
        if($checkExamStatus ==0)
        {
            if(!is_null($exam->time_close) && Carbon::parse($exam->time_close) < Carbon::now())
            {
                return redirect('student/exam')->with('error','Bài thi đã kết thúc!!');
            }
            elseif($timeCoutDown <= 5)
            {
                $studentStatus = new App\exam_student_status;
                $studentStatus->exam_id = $id;
                $studentStatus->student_id = Auth::guard('student')->id();
                $studentStatus->status = 'used';
                $studentStatus->time_start = Carbon::now()->format('Y-m-d H:i:s');
                $studentStatus->save();                
                return view('student.doExam')->with('exam',$exam)->with('success',"Bắt đầu làm bài!");
            }
            elseif(Carbon::parse($exam->time_open) <= Carbon::now() && Carbon::parse($exam->time_close) > Carbon::now())
            {
                // insert into exam_student_status
                $studentStatus = new App\exam_student_status;
                $studentStatus->exam_id = $id;
                $studentStatus->student_id = Auth::guard('student')->id();
                $studentStatus->status = 'used';
                $studentStatus->time_start = Carbon::now()->format('Y-m-d H:i:s');
                $studentStatus->save();       
                $remainingTime = Carbon::now()->diffInSeconds($closeTime);
                return view('student.doExam')->with('exam',$exam)->with('remainingTime',$remainingTime)->with('error',"Bạn đã vào thi trễ!");
            }
            elseif(Carbon::parse($exam->time_open) > Carbon::now() && $timeCoutDown > 5)
            { 
                return view('student.countDownExam',compact('timeCoutDown','exam'));
            }
        }
        else
        {
            return redirect()->back()->with('error','Bạn đã làm bài kiểm tra này rồi!');
        }   
    }


    public function postSubmitExam(Request $request, $id)
    {
        $checkExamStatus = App\exam_student_status::where('exam_id',$id)->where('student_id',Auth::guard('student')->id())->first();
        if($checkExamStatus->status =='used')
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
            // update table student_exam_status
            $checkExamStatus->status = 'completed';
            $checkExamStatus->mark = $mark;
            $checkExamStatus->correct_answer = $true_ans;
            $checkExamStatus->time_end = Carbon::now()->format('Y-m-d H:i:s');
            $checkExamStatus->save();

            return view('student.resultAfterExam')->with('exam',$exam)->with('true_ans',$true_ans)->with('e_s_status',$checkExamStatus);
        }
        elseif($checkExamStatus->status =='completed')
        {
            return redirect()->back()->with('error','Bạn đã hoàn thành bài kiểm tra này rồi!');
        }
        else
        {
            return redirect()->back()->with('error','Lỗi!!');
        }
    }

    public function resultDetail($id)
    {
        $currStudent = Auth::guard('student')->id();
        $stStudentExam = App\exam_student_status::find($id);
        if($stStudentExam == NULL)
        {
            return redirect('/student/exam')->with('error','Bạn chưa làm bài kiểm tra này');
        }
        $exam_info = App\exam::find($stStudentExam->exam_id);
        $studentAnswer = App\student_answer::where('exam_id',$stStudentExam->exam_id)->where('student_id',$currStudent)->with('question')->get();

        if($exam_info->type == 'exam' && Carbon::parse($exam_info->time_close) > Carbon::now())
        {
            return redirect('/student/exam')->with('error','Bạn sẽ xem được đáp án chi tiết khi thời gian kiểm tra kết thúc!');
        }

        if($studentAnswer->count() == 0 || $studentAnswer == NULL)
        {
            return view('student.resultDetail')->with('failed','Kết quả: 0 điểm. Bạn chưa trả lời câu hỏi nào của bài kiểm tra!')->with('exam_info',$exam_info);
        }

        return view('student.resultDetail')->with('stStudentExam',$stStudentExam)->with('studentAnswer',$studentAnswer)->with('exam_info',$exam_info);
    }

    public function accSetting()
    {
        $currStudent = Auth::guard('student')->id();
        $you = App\student::find($currStudent);
        return view('student.account')->with('you',$you);
    }
    public function postManagerAccount(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'min:6',
            'password' => 'min:6|confirmed|different:old-password',
            'avatar'=> 'image|mimes:jpeg,png,jpg,svg|max:5000', 
        ]);
        $student = App\student::find(Auth::guard('student')->id());
        if($request->hasFile('avatar')){
            File::delete($student->avatar);
            $file = $request->file('avatar');
            $nameAvatar = $student->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $student->avatar = 'img/avatar/'.$nameAvatar;
        }
        if($request->changepw == 1)
        {
            if(Hash::check($request->old_password , $student->password)){
                $student-> password = Hash::make($request->password);
            }else{
                return redirect()->back()->with('error','Mật khẩu cũ không chính xác!');
            }
        }
        $student->save();
        return redirect('student/accSetting')->with('success','Cập nhật tài khoản thành công!!');
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
        return view('student.confirmDoExam');
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

        Mail::send('mailForgetPassword', ['token'=>$student->remember_token,'student_name'=>$student->name,'student_id'=>$student->id], function ($message)use($request) {
            $message->to($request->email);
            $message->subject('Đặt lại mật khẩu');
        });
        return redirect()->back()->with('success','Vui lòng kiểm tra email để đổi mật khẩu!');
    }

    public function resetpwEmailConfirmStu($id, $token)
    {
        $student = App\student::where('id',$id)->where('remember_token',$token)->first();
        if(!$student)
        {
            return abort(404,'Page not found');
        }
        return view('newPassword')->with('id',$id)->with('token',$token);
    }
    public function pNewPassword(Request $request)
    {
        $this->validate($request,[
            'id' => 'required',
            'token' => 'required',
            'password' => 'min:6|confirmed'
        ]);
        $student = App\student::where('id',$request->id)->where('remember_token',$request->token)->first();
        if(!$student)
        {
            return abort(404,'Page not found');
        }
        $student-> password = Hash::make($request->password);
        $student->remember_token = '';
        $student->save();
        return redirect('/studentLogin')->with('success','Thay đổi thành công!');
    }
}
