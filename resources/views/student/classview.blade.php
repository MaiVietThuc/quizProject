@extends('student_layout')

@section('student_content')
<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item"><a href="/student/"><i class="fa fa-home" aria-hidden="true"></i></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Thông tin lớp học</li>
    </ol>
</nav>

<!-- Page Heading -->
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

{{-- main_content --}}
<h3 class="text-uppercase bg-light p-2 mt-0 mb-3">Thông tin lớp học:</h3>
<div class="row card-box shadow  p-3 mb-1 ml-1 mr-1">
    <div class="col-lg-6 col-12 ">
        <table class="table">
            <tr>
                <td>Mã lớp</td>
                <td>{{$classinf->class_code}}</td>
            </tr>
            <tr>
                <td>Tên lớp:</td>
                <td>{{$classinf->class_name}}</td>
            </tr>
            <tr>
                <td>Sĩ số:</td>
                <td>{{$classinf->student->count()}}</td>
            </tr>
            <tr>
                <td>Môn học:</td>
                <td>{{$classinf->subject->subject_name}}</td>
            </tr>
            <tr>
                <td>Thời gian:</td>
                <td>
                   Từ: {{$classinf->date_open->format('d/m/Y')}} Đến: {{$classinf->date_close->format('d/m/Y')}}
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6 col-12">
        <table class="table">
            <tr>
                <td>Bài kiểm tra:</td>
                <td>
                    {{-- Tổng:{{$classinf->exam->count()}} <br> --}}
                    @foreach ($classinf->exam as $ex)
                        @if( (\Carbon\Carbon::parse($ex->time_close) < \Carbon\Carbon::now() || $ex->type =='exam_test' ) )
                             <a href="{{URL::to('student/resultDetail/'.$ex->id)}}" class="text-decoration-none"> {{$ex->title}}<span class="badge badge-secondary ml-2">=> chi tiết</span></a>
                            <br>
                        @else
                            {{$ex->title}}
                            <span class="badge badge-info ml-2">Chưa tới ngày kiểm tra</span>
                            <br>
                        @endif
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection