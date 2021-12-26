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

class TeacherController extends Controller
{
    public function getTeacherLogin()
    {
        if(Auth::guard('teacher')->check())
        {
            return redirect()->back();
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



    // get show
    public function getDashboard()
    {
        $currTeacher = App\teacher::with(['subject'])->find(Auth::guard('teacher')->id());
        // print_r($currTeacher);
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
        return view('teacher.classManager')->with('classinf',$classinf);
    }

    public function showHistoryClass()
    {
        $class = App\cclass::where('teacher_id','=',(Auth::guard('teacher')->id()))->where('date_close','<',date('Y-m-d'))->get();
        return view('teacher.historyClass')->with('class',$class);

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
        return view('teacher.addExam')->with('currTeacher',$currTeacher);
    }

    // post add exam
    public function postAddExam(Request $request)
    {
        $this -> validate($request,[
            'name' => 'required|unique:exam,title|string|min:2|max:200',
            'duration' => 'required',
            'class' => 'required',
            'type' => 'required',
            'status' => 'required',
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
        $exam->status = $request->status;
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
    public function repFeedback($id)
    {
        $feedback = App\exam_feedback::find($id)->with('exam')->with('student')->get();
        // print_r($feedback);
        return view('teacher.repFeedback')->with('feedback',$feedback);  
    }
}
