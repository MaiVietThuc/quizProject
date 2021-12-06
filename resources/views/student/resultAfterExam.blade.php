@extends('student_layout')
@section('student_content')

@if (Session('success'))
<div class="alert alert-success alert-dismissible text-center position-fixed" id="bt-alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    {{session('success')}}!
</div>
@endif
@if (Session('error'))
<div class="alert alert-danger alert-dismissible text-center position-fixed" id="bt-alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    {{session('error')}}!
</div>
@endif

<div class="container text-center d-flex align-items-center justify-content-center">
    <div>
        <div class="title-page mb-5">
            <h1>Kết quả</h1>
            <h4>{{$exam->title}}</h4>
        </div>
        <div class="exam-result mb-3">
            <h4 class="font-weight-bold">{{$e_s_status->mark}}/{{$exam->total_marks}} Điểm</h4>
            <p>Làm đúng: {{$true_ans}}/{{$exam->total_question}} câu</p>
        </div>
        <div class="mb-4">
            <h4>Thời gian làm</h4>
            <span>{{\Carbon\Carbon::parse($e_s_status->time_start)->format('H:i:s')}} đến {{\Carbon\Carbon::parse($e_s_status->time_end)->format('H:i:s')}} ngày {{\Carbon\Carbon::parse($e_s_status->time_open)->format('d-m-Y')}}</span>
        </div>
        @if (!Session('success'))
        <div class="mb-3">
            <h6>Phản hồi đề kiểm tra:</h6>
            <form action="{{URL::to('/student/postExamFeedback')}}" method="post" autocomplete="off">
                @csrf
                <div class="form-group">
                    <textarea name="feedback_content" id="" cols="50" rows="5"></textarea>
                    <input type="hidden" name="exam_id" value="{{$exam->id}}">
                </div>
                <button type="submit" class="btn btn-outline-info">Gửi</button>
            </form>
        </div>
        @endif
        <div>
            <a href="{{URL::to('student/resultDetal/'.$e_s_status->id.'')}}"><button class="btn btn-outline-primary bg-primary text-light">Xem chi tiết</button></a>
            <a href="{{URL::to('student/exam')}}"><button class="btn btn-outline-primary bg-primary text-light">Trang chủ</button></a>
        </div>
    </div>
</div>
@endsection