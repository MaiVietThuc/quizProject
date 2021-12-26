@extends('student_layout')
@section('student_content')
    <div class="d-flex justify-content-center align-items-center mt-3">
        <h2>{{$exam->title}}</h2>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-3">
         <h5>Thời gian làm bài: <strong> {{$exam->duration}} phút</strong></h5>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-3">
        <h5>Số lượng câu hỏi: <strong>{{$exam->total_question}} câu</strong></h5>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-3">
        <h5>Điểm tối đa: <strong>{{$exam->total_marks}} điểm</strong> </h5>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-3">
        <h5>Lưu ý của giảng viên: <strong>sinh viên không dùng tài liệu</strong> </h5>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <p  class="font-italic">Khi đã chọn làm bài, thời gian làm bài sẽ bắt đầu được tính và sinh viên cần hoàn thành bài thi trong 
            phiên làm bài đó. Nếu trong quá trình làm bài sinh viên thoát ra ngoài coi như sinh viên hủy thi.</p>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-3">
        <button class="bg-primary rounded btn-lg"><a class="text-white text-decoration-none" href="{{URL::to('student/doExam/'.$exam->id)}}">Bắt đầu làm bài</a></button>
    </div>
@endsection