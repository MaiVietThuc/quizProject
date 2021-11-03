<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function adminLogin(Request $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
          
        if (Auth::guard('admin')->attempt($arr)) {
            echo 'đăng nhập thành công';
        } else {
            echo 'tài khoản và mật khẩu chưa chính xác';
            var_dump($arr);
            if (Auth::check()) {
                dd('ddax đăng nhập');
            } else {
                     dd('chua đăng nhập');                    
            }
        }
    }

    public function getDashboard()
    {
        $count = array();
        $count['teacher'] = App\teacher::all()->count();
        $count['admin'] = App\admin::all()->count();
        $count['student'] = App\student::all()->count();
        $count['class'] = App\cclass::all()->count();
        $count['exam'] = App\exam::all()->count();
        $count['majors'] = App\majors::all()->count();
        $count['seenFeedback'] = App\feedback::where('status','=','1')->count();
        $count['allFeedback'] = App\feedback::all()->count();
        return view('admin.dashboard',compact('count'));
    }

    public function getStudent()
    {
        $students = App\student::all();
        return view('admin.showStudent',compact('students'));
    }
    public function getTeacher()
    {
        // $teachers = App\teacher::all();
        $teachers = App\teacher::with(['subject'])->get();
        return view('admin.showTeacher',compact('teachers'));
    }
    public function getClass()
    {
        $class = App\cclass::with(['subject','teacher','student'])->get() ;
        return view('admin.showClass',compact('class'));
    }
    public function getExam()
    {
        $exams = App\exam::all();
        return view('admin.showExam',compact('exams'));
    }
    public function getMajors()
    {
        $majors = App\majors::all();
        return view('admin.showMajors',compact('majors'));
    }
    public function getFeedback()
    {
        $feedbacks = App\feedback::all();
        return view('admin.showFeedback',compact('feedbacks'));
    }
    public function getAdminAccount()
    {
        $admins = App\admin::all();
        return view('admin.showAdmin',compact('admins'));
    }



    // get add
    public function getAddStudent()
    {
        $majors = App\majors::all();
        return view('admin.addStudent',compact('majors'));
    }
    public function getAddTeacher()
    {
        $subjects = App\subject::where('status','=','1')->get();
        return view('admin.addTeacher',compact('subjects'));
    }





    // post add data 
    public function postAddStudent(Request $request)
    {
        $this -> validate($request,[
            'mssv' => 'required|unique:student,student_code|min:9|max:11',
            'name' => 'required',
            'majors' => 'required',
            'password' =>'required|confirmed|min:6',
            'email' => 'unique:student,email',
            'avatar'=> 'image|mimes:jpeg,png,jpg,svg|max:5000',
        ]);
        $student = new App\student;
        $student->student_code = $request->mssv;
        $student->name = $request->name;
        $student->gender = $request->gender;
        $student->majors_id = $request->majors;
        $student->password = Hash::make($request->password);
        $student->status = $request->status;
        $student->email = $request->email;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $nameAvatar = $student->student_code.'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $student->avatar = 'img/avatar/'.$nameAvatar;
        }else{
            $student->avatar = '/img/user.png';
        }
        // $student->created_at = Carbon::now()->toDateTimeString();
        $student ->save();

        return redirect('admin/getAddStudent')->with('success','Thêm sinh viên thành công');
    }

    public function postAddTeacher(Request $request)
    {
        $this -> validate($request,[
            'name' => 'required',
            'password' =>'required|confirmed|min:6',
            'email' => 'unique:teacher,email',
            'avatar'=> 'image|mimes:jpeg,png,jpg,svg|max:5000',
        ]);
        $teacher = new App\teacher;
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->gender = $request->gender;
        $teacher->password  = Hash::make($request->password);
        $teacher->status = $request->status;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $nameAvatar = $teacher->id.'teach'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $teacher->avatar = 'img/avatar/'.$nameAvatar;
        }else{
            $teacher->avatar = '/img/user.png';
        }
        // $student->created_at = Carbon::now()->toDateTimeString();
        $teacher ->save();
        // 
        if(!empty($request->subj)){
            $subj= $request->subj;
            // $teacher = App\teacher::find(2);
            $teacher->subject()->attach($subj);
        }
        return redirect('admin/getAddTeacher')->with('success','Thêm giảng viên thành công');
    }

    public function postAddMajors(Request $request)
    {
        $this-> validate($request,[
            'mcn' => 'required|unique:majors,majors_code',
            'name'=> 'required|unique:majors,name',
        ]);
        $majors = new App\majors;
        $majors->name = $request->name;
        $majors->majors_code = $request->mcn;
        $majors->status = $request->status;
        $majors->save();
        return redirect('admin/getAddMajors')->with('success','Thêm Chuyên ngành thành công');
    }





    // change status
    public function changeTeacherStatus($id, $status)
    {
        $teacher = App\teacher::find($id);
        if($status =='off'){
            $teacher->status = 0;          
        }elseif($status  =='on'){
            $teacher->status= 1;
        }
        $teacher ->save();
        return redirect('admin/teacher')->with('complete', 'Sửa thành công');
    }
    public function changeStudentStatus($id, $status)
    {
        $student = App\student::find($id);
        if($status =='off'){
            $student->status = 0;          
        }elseif($status  =='on'){
            $student->status= 1;
        }
        $student ->save();
        return redirect('admin/student')->with('complete', 'Sửa thành công');
    }
    public function changeAdminStatus($id, $status)
    {
        $admin = App\admin::find($id);
        if($status =='off'){
            $admin->status = 0;          
        }elseif($status  =='on'){
            $admin->status= 1;
        }
        $admin ->save();
        return redirect('admin/adminAccount')->with('complete', 'Sửa thành công');
    }
    public function changeClassStatus($id, $status)
    {
        $class = App\cclass::find($id);
        if($status =='off'){
            $class->status = 0;          
        }elseif($status  =='on'){
            $class->status= 1;
        }
        $class ->save();
        return redirect('admin/class')->with('complete', 'Sửa thành công');
    }
    public function changeMajorsStatus($id, $status)
    {
        $majors = App\majors::find($id);
        if($status =='off'){
            $majors->status = 0;          
        }elseif($status  =='on'){
            $majors->status= 1;
        }
        $majors ->save();
        return redirect('admin/majors')->with('complete', 'Sửa thành công');
    }



    // get edit
    public function getEditStudent($id)
    {
        $majors = App\majors::all();
        $student = App\student::find($id);
        return view('admin.editStudent')->with('majors',$majors)->with('student',$student);
    }
    public function getEditTeacher($id)
    {
        $teacher = App\teacher::where('id',$id)->with(['subject'])->first();
        $subjects = App\subject::all();
        return view('admin.editTeacher')->with('teacher',$teacher)->with('subjects',$subjects);
        // print_r($id);
    }


    // post edit
    public function postEditStudent(Request $request, $id)
    {
        $this -> validate($request,[
            'studentNumber' => 'required|min:9|max:11',
            'studentName' => 'required',
            'studentMajors' => 'required',
            'password' =>'confirmed|min:6',
            'avatar'=> 'image|mimes:jpeg,png,jpg,svg|max:5000',
        ]);
        $student = App\student::find($id);
        $student->student_code = $request->studentNumber;
        $student->name = $request->studentName;
        $student->gender = $request->gender;
        $student->majors_id = $request->studentMajors;
        if($request->changepw ==1){
            $student->password = Hash::make($request->password);
        }
        $student->status = $request->status;
        $student->email = $request->email;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $nameAvatar = $student->student_code.'_'.rad(1,9999).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $student->avatar = 'img/avatar/'.$nameAvatar;
        }
        // $student->created_at = Carbon::now()->toDateTimeString();
        $student ->save();
        return redirect('admin/student')->with('complete','Sửa thành công');
    }
    public function postEditTeacher(Request $request, $id)
    {
        $this -> validate($request,[
            'studentNumber' => 'required|min:9|max:11',
            'studentName' => 'required',
            'studentMajors' => 'required',
            'password' =>'confirmed|min:6',
            'avatar'=> 'image|mimes:jpeg,png,jpg,svg|max:5000',
        ]);
        $student = App\student::find($id);
        $student->student_code = $request->studentNumber;
        $student->name = $request->studentName;
        $student->gender = $request->gender;
        $student->majors_id = $request->studentMajors;
        if($request->changepw ==1){
            $student->password = Hash::make($request->password);
        }
        $student->status = $request->status;
        $student->email = $request->email;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $nameAvatar = $student->student_code.'_'.rad(1,9999).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $student->avatar = 'img/avatar/'.$nameAvatar;
        }
        // $student->created_at = Carbon::now()->toDateTimeString();
        $student ->save();

        return redirect('admin/student')->with('complete','Sửa thành công');
        //     echo 
        // $request->studentNumber .'<hr>'.
        // $request->studentName .'<hr>'.
        // $request->gender .'<hr>'.
        // $request->studentMajors .'<hr>'.
        // $request->changepw .'<hr>'.
        // $request->email;
    }
}
