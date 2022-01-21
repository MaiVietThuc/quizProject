<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\File; 

class TeacherController extends Controller
{
    public function getTeacherLogin()
    {
        if(Auth::guard('teacher')->check())
        {
            return redirect('/teacher');
        }
        else
        {
            return  view('teacher.teacher_login');
        }
    }

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

    public function postManagerAccount(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'min:6',
            'password' => 'min:6|confirmed|different:old-password',
            'avatar'=> 'image|mimes:jpeg,png,jpg,svg|max:5000', 
        ]);
        $teacher = App\teacher::find(Auth::guard('teacher')->id());
        if($request->hasFile('avatar')){
            File::delete($teacher->avatar);
            $file = $request->file('avatar');
            $nameAvatar = $currAccount->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $teacher->avatar = 'img/avatar/'.$nameAvatar;
        }
        if(changepw ==1)
        {
            if(Hash::check($request->old_password , $teacher->password)){
                $teacher-> password = Hash::make($request->password);
            }else{
                return redirect()->back()->with('error','Mật khẩu cũ không chính xác!');
            }
        }
        $teacher->save();
        return redirect('student/info')->with('success','Cập nhật tài khoản thành công!!');
    }

    // get show
    public function getDashboard()
    {
        $currTeacher = App\teacher::with(['subject'])->find(Auth::guard('teacher')->id());

        // get class
        $now = date('Y-m-d');
        $teachClass =App\cclass::where('teacher_id','=',(Auth::guard('teacher')->id()))->where('date_close','>=',$now)->count();

        // get feedback 
        $feedbackId = DB::table('class')->join('exam','class.id','=','exam.class_id')
        ->join('exam_feedback','exam.id','=','exam_feedback.exam_id')
        ->select('exam_feedback.id')->where('class.teacher_id','=',Auth::guard('teacher')->id())
        ->get();
        $FbId = array();
        foreach($feedbackId as $fb)
        {
            $FbId[] = $fb->id ;
        }
        $feedback = App\exam_feedback::whereIn('id',$FbId)->count();
        $feedbackNotRep = App\exam_feedback::whereIn('id',$FbId)->where('teacher_rep',NULL)->count();

        // getExam
        $classesId = App\cclass::select('id')->where('teacher_id','=',Auth::guard('teacher')->id())->get()->toArray();
        $exams = App\exam::whereIn('class_id',$classesId)->where('status',0)->count();

        return view('teacher.dashboard',compact('feedback','feedbackNotRep','exams'))->with('currTeacher',$currTeacher);
    }

    public function teacherInfo()
    {
        $currTeacher = App\teacher::find(Auth::guard('teacher')->id());
        return view('teacher.accountInfo')->with('currTeacher',$currTeacher);
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
        return view('teacher.classManager')->with('classinf',$classinf);
    }

    public function showHistoryClass()
    {
        $class = App\cclass::where('teacher_id','=',(Auth::guard('teacher')->id()))->where('date_close','<',date('Y-m-d'))->get();
        return view('teacher.historyClass')->with('class',$class);
    }

    public function getHistoryClassManager($id)
    {
        $classinf = App\cclass::with(['student'])->find($id);
        return view('teacher.classManager')->with('classinf',$classinf);
    }

    public function showTeacherExamAvalable()
    {
        $classesId = App\cclass::select('id')->where('teacher_id','=',Auth::guard('teacher')->id())->get()->toArray();
        // $exams = App\exam::findMany($classesId)->where('time_close','>',Carbon::now());
        $exams = App\exam::whereIn('class_id',$classesId)->where('time_close','>',Carbon::now())->orWhere('type','=','exam_test')->get();
        return view('teacher.exam')->with('exams',$exams);
    }

    public function showTeacherExamHistory()
    {
        $classesId = App\cclass::select('id')->where('teacher_id','=',Auth::guard('teacher')->id())->get()->toArray();
        $exams = App\exam::whereIn('class_id',$classesId)->where('time_close','<',Carbon::now())->orWhere('type','=','exam_test')->get();
        // $exams = App\exam::findMany($classesId)->where('time_close','<',Carbon::now());
        return view('teacher.historyExam')->with('exams',$exams);
    
    }


    // delete student from class
    public function deleteStudentInClass($class_id, $student_id)
    {
        $class = App\cclass::find($class_id);
        if(Carbon::parse($class->date_close) < Carbon::now()){
            return redirect()->back()->with('error','Không thể xóa vì lớp học này đã kết thúc!');
        }
        $class->student()->detach($student_id);
        return redirect('teacher/class/manager/'.$class_id.'')->with('success','Xóa thành công!');
    }


    // change exam status
    public function turnOnExamStatus($id)
    {
        $exam = App\exam::find($id);
        $exam->status = 1;
        $exam->save();
        return redirect('teacher/exam')->with('success','Sửa thành công!');
    }

    public function turnOffExamStatus($id)
    {
        $exam = App\exam::find($id);
        $exam->status = 0;
        $exam->save();
        return redirect('teacher/exam')->with('success','Sửa thành công!');
    }

    // get add exam
    public function getAddExam()
    {
        $currTeacher = App\teacher::find(Auth::guard('teacher')->id());
        $cclass = App\cclass::where('teacher_id',Auth::guard('teacher')->id())->where('date_close','>',Carbon::now())->get();
        return view('teacher.addExam')->with('currTeacher',$currTeacher)->with('cclass',$cclass);
    }

    // post add exam
    public function postAddExam(Request $request)
    {
        $this -> validate($request,[
            'name' => 'required|unique:exam,title|string|min:2|max:200',
            'duration' => 'required',
            'class' => 'required',
            'type' => 'required',
        ]);
        $exam = new App\exam;
        $exam->title = $request->name;
        $exam->duration = $request->duration;
        if($request->type == "exam")
        {
            $time_open = str_replace('T',' ',$request->time_open);
            $exam->time_open = $time_open;
            $time_close = Carbon::parse($time_open)->addMinutes($request->duration)->format('Y/m/d H:i:s');
            $exam->time_close = $time_close;
        }
        $exam->status = 0;
        $exam->class_id = $request->class;
        $exam->type = $request->type;
        $exam->save();
        return redirect('teacher/exam/getManagerExam/'.$exam->id.'')->with('success','Thêm thành công');
    }

    public function postEditExam(Request $request, $id)
    {
        $this -> validate($request,[
            'name' => 'required|string|min:2|max:200',
            'duration' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);
        $exam = App\exam::find($id);
        $exam->title = $request->name;
        $exam->duration = $request->duration;
        if($request->type == "exam")
        {
            $time_open = str_replace('T',' ',$request->time_open);
            $exam->time_open = $time_open;
            $time_close = Carbon::parse($time_open)->addMinutes($request->duration)->format('Y/m/d H:i:s');
            $exam->time_close = $time_close;
        }
        $exam->status = $request->status;
        $exam->type = $request->type;
        $exam->update();
        return redirect()->back()->with('success','Sửa thành công');
    }

    public function deleteExam($id)
    {
        $exam = App\exam::find($id);
        $exam->delete();
        return redirect('teacher/exam')->with('success','Xóa thành công!');
    }

    // get getManagerExam
    public function getManagerExam($id)
    {
        $exam = App\exam::find($id);
        return view('teacher.managerExam')->with('exam',$exam);
    }

    // add question
    public function postAddQuestion(Request $request, $id)
    {
        $this->validate($request,[
            'question'=> 'required',
            'question-img' => 'image|mimes:jpeg,png,jpg,svg|max:5000',
            'answer_A' => 'required',
            'answer_B' => 'required',
            'mark' => 'required|min:0.05|max:10',
            'correct_answer'=> 'required',
        ]);
        $question = new App\question;
        $question->question_title = $request->question;
        $question->ans_1 = $request->answer_A;
        $question->ans_2 = $request->answer_B;
        $question->ans_3 = $request->answer_C;
        $question->ans_4 = $request->answer_D;
        $question->mark = $request->mark;
        $question->exam_id = $id;
        if($request->hasFile('question_img'))
        {
            $file = $request->file('question_img');
            $nameimg = $id.''.Str::random(6).''.$file->getClientOriginalName('question_img');
            $file->move('img/ques',$nameimg);
            $question->question_img = 'img/ques/'.$nameimg;
        }
        $question->corr_ans = $request->correct_answer;
        $question->save();
        // update ttmark
        $ttmark = App\question::where('exam_id',$question->exam_id)->sum('mark');
        $ttquestion = App\question::where('exam_id',$question->exam_id)->count();
        App\exam::where('id',$question->exam_id)->update(['total_marks'=>$ttmark,'total_question'=>$ttquestion]);

        return redirect('teacher/exam/getManagerExam/'.$question->exam_id.'')->with('success','Thêm thành công!');
    }

    public function deleteQuestion($id)
    {
        $question = App\question::find($id);
        $question->delete();
        // update ttmark
        $ttmark = App\question::where('exam_id',$question->exam_id)->sum('mark');
        $ttquestion = App\question::where('exam_id',$question->exam_id)->count();
        App\exam::where('id',$question->exam_id)->update(['total_marks'=>$ttmark,'total_question'=>$ttquestion]);
        return redirect()->back()->with('success','Xóa thành công!');
    }

    public function getEditQuestion($id)
    {
        $question = App\question::find($id);
        return view('teacher/editQuestion')->with('question',$question);
    }

    public function postEditQuestion(Request $request, $id)
    {
        $this->validate($request,[
            'question'=> 'required',
            'question-img' => 'image|mimes:jpeg,png,jpg,svg|max:5000',
            'answer_A' => 'required',
            'answer_B' => 'required',
            'mark' => 'required|min:0.05|max:10',
            'correct_answer'=> 'required',
        ]);
        $question = App\question::find($id);
        $question->question_title = $request->question;
        $question->ans_1 = $request->answer_A;
        $question->ans_2 = $request->answer_B;
        $question->ans_3 = $request->answer_C;
        $question->ans_4 = $request->answer_D;
        $question->mark = $request->mark;
        if($request->hasFile('question_img'))
        {
            $file = $request->file('question_img');
            $nameimg = $id.''.Str::random(6).''.$file->getClientOriginalName('question_img');
            $file->move('img/ques',$nameimg);
            $question->question_img = 'img/ques/'.$nameimg;
        }
        $question->corr_ans = $request->correct_answer;
        $question->save();
        // update ttmark
        $ttmark = App\question::where('exam_id',$question->exam_id)->sum('mark');
        $ttquestion = App\question::where('exam_id',$question->exam_id)->count();
        App\exam::where('id',$question->exam_id)->update(['total_marks'=>$ttmark,'total_question'=>$ttquestion]);

        return redirect('teacher/exam/getManagerExam/'.$question->exam_id.'')->with('success','Sửa thành công!');
    }
    
    public function showFeedback()
    {
        $feedbackId = DB::table('class')->join('exam','class.id','=','exam.class_id')
        ->join('exam_feedback','exam.id','=','exam_feedback.exam_id')
        ->select('exam_feedback.id')->where('class.teacher_id','=',Auth::guard('teacher')->id())
        ->get();
        $FbId = array();
        foreach($feedbackId as $fb)
        {
            $FbId[] = $fb->id ;
        }
        $feedback = App\exam_feedback::whereIn('id',$FbId)->with('exam')->with('student')->get();
        return view('teacher.examFeedback')->with('feedback',$feedback);
    }
    public function repFeedback(Request $request, $id)
    {
        $this->validate($request,[
            'teacherRepFeedback' => 'required', 
        ]);
        $feedback = App\exam_feedback::find($id);
        $feedback->teacher_rep = $request->teacherRepFeedback;
        $feedback->save();
        return redirect('teacher/feedback')->with('success','Trả lời thành công!');
    }


    // exam result
    public function classExamResult($id)
    {
        $examInfo = App\exam::where('id',$id)->with('cclass')->first();
        $classExamResult = App\exam_student_status::where('exam_id',$id)->with('student')->get();
        return view('teacher.classExamResult')->with('examInfo',$examInfo)->with('classExamResult',$classExamResult);
    }


    // get detail result studentExam
    public function studentExamResultDetail($studentId, $examId)
    {
        $studentInf = App\student::find($studentId);
        $stStudentExam = App\exam_student_status::where('student_id',$studentId)->where('exam_id',$examId)->first();
        if($stStudentExam == NULL)
        {
            return redirect()->back()->with('error','Sinh viên chưa làm bài kiểm tra này');
        }
        $exam_info = App\exam::find($examId);
        $studentAnswer = App\student_answer::where('exam_id',$examId)->where('student_id',$studentId)->with('question')->get();

        if($exam_info->type == 'exam' && Carbon::parse($exam_info->time_close) > Carbon::now())
        {
            return redirect()->back()->with('error','Bạn sẽ xem được đáp án chi tiết khi thời gian kiểm tra kết thúc!');
        }

        if($studentAnswer->count() == 0 || $studentAnswer == NULL)
        {
            return view('teacher.studentresultDetail')->with('failed','Sinh viên chưa trả lời câu hỏi nào của bài kiểm tra!')->with('exam_info',$exam_info);
        }
        return view('teacher.studentresultDetail')->with('stStudentExam',$stStudentExam)->with('studentAnswer',$studentAnswer)
        ->with('exam_info',$exam_info)->with('studentinf',$studentInf);
    }
}
