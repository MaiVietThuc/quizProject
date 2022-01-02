<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function getAdLogin()
    {
        if(Auth::guard('admin')->check())
        {
            return redirect('/admin');
        }
        else
        {
            return view('admin.admin_login');
        }
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|',
            'password' => 'required|min:6',
        ]);
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
          
        if (Auth::guard('admin')->attempt($arr)) {
            return redirect('/admin')->with('success','Chào mừng '.Auth::guard('admin')->user()->name.'!!');
        } else {
            return redirect('/adminlogin')->with('error', 'Thông tin đăng nhập không chính xác!!'); 
        }
    }
    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect('/adminlogin');
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
        $class = App\cclass::with(['subject','teacher','student'])->where('date_close','>',date('Y-m-d'))->get();
        $hisClass = App\cclass::with(['subject','teacher','student'])->where('date_close','<',date('Y-m-d'))->get() ;
        return view('admin.showClass',compact('class','hisClass'));
    }
    public function getExam()
    {
        $exams = App\exam::where('time_close','>',Carbon::now())->get();
        $hisExams = App\exam::where('time_close','<',Carbon::now())->orWhere('type','=','exam_test')->get();
        return view('admin.showExam',compact('exams','hisExams'));
    }
    public function getMajors()
    {
        $majors = App\majors::all();
        return view('admin.showMajors',compact('majors'));
    }
    public function getFeedback()
    {
        $feedbacks = App\feedback::with('student')->get();
        return view('admin.showFeedback',compact('feedbacks'));
    }
    public function getAdminAccount()
    {
        $admins = App\admin::all()->except(Auth::guard('admin')->id());
        return view('admin.showAdmin',compact('admins'));
    }

    public function getManagerClass($id)
    {
        $class = App\cclass::with('student')->find($id);
        $student = App\student::with('majors')->get();
        return view('admin.managerClass')->with('class',$class)->with('student',$student);
    }

    public function classExamResult($id)
    {
        $examInfo = App\exam::where('id',$id)->with('cclass')->first();
        $classExamResult = App\exam_student_status::where('exam_id',$id)->with('student')->get();
        return view('admin.classExamResult')->with('examInfo',$examInfo)->with('classExamResult',$classExamResult);
    }

    public function showExamQuestion($id)
    {
        $exam = App\exam::with('question')->where('id',$id)->first();
        if($exam->time_close < Carbon::now() || $exam->type == 'exam_test')
        {
            return view('admin.viewExamQuestion',compact('exam'));
        }else{
            return redirect('/showExamQuestionADM/'.$id);
        }
    }

    public function showExamQuestionADM($id)
    {
        $exam = App\exam::with('question')->where('id',$id)->first();
        return view('admin.viewExamQuestion',compact('exam'));
    }
        
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
            return redirect()->back()->with('error','Bài kiểm tra chưa kết thúc!');
        }

        if($studentAnswer->count() == 0 || $studentAnswer == NULL)
        {
            return view('teacher.studentresultDetail')->with('failed','Sinh viên chưa trả lời câu hỏi nào của bài kiểm tra!')->with('exam_info',$exam_info);
        }
        return view('admin.studentResultDetail')->with('stStudentExam',$stStudentExam)->with('studentAnswer',$studentAnswer)
        ->with('exam_info',$exam_info)->with('studentinf',$studentInf);
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
    public function getAddAdmin()
    {
        $role = App\admin_role::all();
        return view('admin.addAdmin',compact('role'));
    }
    public function getAddClass()
    {
        $subjects = App\subject::all();
        $teacher = App\teacher::all();
        return view('admin.addClass',compact('subjects','teacher'));
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
            $nameAvatar = $student->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
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
            $nameAvatar = $teacher->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $teacher->avatar = 'img/avatar/'.$nameAvatar;
        }else{
            $teacher->avatar = '/img/user.png';
        }
        $teacher ->save();
        // 
        if(!empty($request->subj)){
            $subj= $request->subj;
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
    
    public function postAddAdmin(Request $request)
    {
        $this ->validate($request,[
            'name'=> 'required|unique:admin,name',
            'email'=> 'required|unique:admin,email',
            'password'=> 'required|confirmed|min:6',
            'role'=> 'required',
            'file'=> 'image|mimes:jpeg,png,jpg,svg|max:5000',
        ]);
        $admin = new App\admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role_id =$request->role;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $nameAvatar = $admin->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $admin->avatar = 'img/avatar/'.$nameAvatar;
        }else{
            $admin->avatar = '/img/user.png';
        }
        $admin ->save();
        return redirect('admin/getAddAdmin')->with('success','Thêm thành công');
    }
    public function postAddClass(Request $request)
    {
        $this->validate($request,[
            'class_code' => 'required|unique:class,class_code',
            'name' => 'required|unique:class,class_name',
            'subject'=> 'required',
            'teacher'=> 'required',
            'date_open' => 'required|',
            'date_close' => 'required|after:date_open',
            'status' => 'required',
        ]);
        $class = new App\cclass;
        $class->class_code = $request->class_code;
        $class->class_name = $request->name;
        $class->subject_id = $request->subject;
        $class->teacher_id = $request ->teacher;
        $class->status = $request->status;
        $class->date_open = $request->date_open;
        $class->date_close = $request->date_close;
        $class->save(); 
        return redirect('admin/class')->with('success','Thêm thành công!!');
    }

    public function postClassAddStudent(Request $request, $id)
    {
        $class = App\cclass::find($id);
        if(!empty($request->student)){
            $student= $request->student;
            $class->student()->attach($student);
        }
        return redirect()->back()->with('success','Thêm thành công!!');
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
        return redirect('admin/teacher')->with('success', 'Sửa thành công');
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
        return redirect('admin/student')->with('success', 'Sửa thành công');
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
        return redirect('admin/adminAccount')->with('success', 'Sửa thành công');
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
        return redirect('admin/class')->with('success', 'Sửa thành công');
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
        return redirect('admin/majors')->with('success', 'Sửa thành công');
    }

    public function changeFeedbackStatus($id, $status)
    {
        $feedback = App\feedback::find($id);
        if($status =='off'){
            $feedback->status = 0;          
        }elseif($status  =='on'){
            $feedback->status= 1;
        }
        $feedback ->save();
        return redirect('admin/feedback')->with('success', 'Sửa thành công');
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
        $teach_sub_coll = array();
        foreach($teacher->subject as $val){
            array_push($teach_sub_coll,$val->id);
        }
        $teach_subj = App\subject::find($teach_sub_coll);
        $subjects = App\subject::whereNotIn('id',$teach_sub_coll)->get();
        return view('admin.editTeacher')->with('teacher',$teacher)->with('subjects',$subjects)->with('teach_subj',$teach_subj);
    }
    public function getEditMajors($id)
    {
        $major = App\majors::find($id);
        return view('admin.editMajors',compact('major'));
    }
    public function getEditAdmin($id)
    {
        $admin = App\admin::find($id);
        $ad_role = App\admin_role::all();
        return view('admin.editAdmin',compact('admin','ad_role'));
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
            $nameAvatar = $student->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $student->avatar = 'img/avatar/'.$nameAvatar;
        }
        // $student->created_at = Carbon::now()->toDateTimeString();
        $student ->save();
        return redirect('admin/student')->with('success','Sửa thành công');
    }

    public function postEditTeacher(Request $request, $id)
    {
        $this -> validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password' =>'confirmed|min:6',
            'avatar'=> 'image|mimes:jpeg,png,jpg,svg|max:5000',
        ]);
        $teacher = App\teacher::find($id);
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->gender = $request->gender;
         if(!empty($request->subjects)){
            $subj= $request->subjects;
            $teacher->subject()->detach();
            $teacher->subject()->attach($subj);
        }
        if($request->changepw ==1){
            $teacher->password = Hash::make($request->password);
        }
        $teacher->status = $request->status;
        $teacher->email = $request->email;
        if($request->hasFile('avatar')){
            if($teacher->avatar!=''){
                Storage::disk('public')->delete($teacher->avatar);
            }
            $file = $request->file('avatar');
            $nameAvatar = $teacher->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $teacher->avatar = 'img/avatar/'.$nameAvatar;
        }
        $teacher ->save();
        return redirect('admin/teacher')->with('success','Sửa thành công');
    }

    public function postEditMajors(Request $request, $id)
    {
        $this -> validate($request,[
            'mcn' => 'required|min:3',
            'name' => 'required',
            'status' => 'required',
        ]);
        $major = App\majors::find($id);
        $major->majors_code = $request->mcn;
        $major->name = $request->name;
        $major->status = $request->status;
        $major->save();
        return redirect('admin/majors')->with('success','Sửa thành công');
    }

    public function postEditAdmin(Request $request, $id)
    {
        $this -> validate($request,[
            'name'=> 'required',
            'email'=> 'required',
            'password'=> 'required|confirmed|min:6',
            'role'=> 'required',
            'file'=> 'image|mimes:jpeg,png,jpg,svg|max:5000',
        ]);
        $admin = App\admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->status = $request->status;
        if($request->changepw ==1){
            $admin->password = Hash::make($request->password);
        }
        if($request->hasFile('avatar')){
            if($admin->avatar!=''){
                Storage::disk('public')->delete($admin->avatar);
            }
            $file = $request->file('avatar');
            $nameAvatar = $admin->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $admin->avatar = 'img/avatar/'.$nameAvatar;
        }
        $admin->role_id = $request->role;
        $admin->save();
        return redirect('admin/adminAccount')->with('success','Sửa thành công!');
    }



    // delete
    public function deleteTeacher($id)
    {
        $teacher = App\teacher::find($id);
        try {

            $teacher->subject()->detach();
            $teacher->delete();
            return redirect('admin/teacher')->with('success','Đã xóa thành công!');
          
          } catch (\Exception $e) {
              return redirect('admin/teacher')->with('error',$e);
          }
       
    }
    public function deleteStudent($id)
    {
        $student = App\student::find($id);
        try {
            $student->cclass()->detach();
            $student->delete();
            return redirect('admin/student')->with('success','Đã xóa thành công!');    
          } catch (\Exception $e) {
              return redirect('admin/student')->with('error',$e);
          }
    }
    public function deleteMajors($id)
    {
        $major = App\majors::find($id);
        try {
            $major->delete();
            return redirect('admin/majors')->with('success','Đã xóa thành công!');    
        }catch (\Exception $e) {
              return redirect('admin/majors')->with('error',$e);
        }
    }

    public function deleteClass($id)
    {
        $class = App\cclass::find($id);
        if($class->date_open< Carbon::now && $class)
        {
            return redirect()->back()->with('error','Không thể xóa lớp đang học!');    
        }else{
            $class->delete();
            return redirect('admin/class')->with('success','Đã xóa thành công!');   
        }
     
    }

    public function deleteExam($id)
    {
        $exam = App\exam::find($id);
        try {
            $exam->delete();
            return redirect('admin/exam')->with('success','Đã xóa thành công!');    
        }catch (\Exception $e) {
              return redirect('admin/exam')->with('error',$e);
        }
    }

    public function deleteFeedback($id)
    {
        $feedback = App\feedback::find($id);
        try {
            $feedback->delete();
            return redirect('admin/feedback')->with('success','Đã xóa thành công!');    
        }catch (\Exception $e) {
              return redirect('admin/feedback')->with('error',$e);
        }
    }

    public function deleteAdmin($id)
    {
        $admin = App\admin::find($id);
        try {
            $admin->delete();
            return redirect('admin/adminAccount')->with('success','Đã xóa thành công!');    
          } catch (\Exception $e) {
              return redirect('admin/adminAccount')->with('error',$e);
          }
    }

       // delete student from class
       public function deleteStudentInClass($class_id, $student_id)
       {
           $class = App\cclass::find($class_id);
           if(Carbon::parse($class->date_close) < Carbon::now()){
               return redirect()->back()->with('error','Không thể xóa vì lớp học này đã kết thúc!');
           }
           $class->student()->detach($student_id);
           return redirect('admin/managerClass/'.$class_id.'')->with('success','Xóa thành công!');
       }

    // account manager
    public function adAccountSetting()
    {
        $currAdmin = App\admin::find(Auth::guard('admin')->id());
        return view('admin.adAccountSetting')->with('currAdmin',$currAdmin);
    }
    public function postAccountSetting(Request $request)
    {
        $this ->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'old_password' => 'min:6',
            'password' => 'min:6|confirmed|different:old-password',
            'avatar'=> 'image|mimes:jpeg,png,jpg,svg|max:5000', 
        ]);
        $currAccount = App\admin::find(Auth::guard('admin')->id());
        $currAccount->name = $request ->name;
        $currAccount->email = $request ->email;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $nameAvatar = $currAccount->email.'_'.Str::random(4).'_'.$file->getClientOriginalName('avatar');
            $file->move('img/avatar',$nameAvatar);
            $currAccount->avatar = 'img/avatar/'.$nameAvatar;
        }else{
            $currAccount->avatar = '/img/user.png';
        }
        if($request-> changepw ==1){
            if(Hash::check($request->old_password , $currAccount->password)){
                $currAccount-> password = Hash::make($request->password);
            }
        }
        $currAccount->save();
        return redirect('admin/')->with('success','Cập nhật tài khoản thành công!!');
    }

  

}
