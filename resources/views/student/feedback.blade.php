@extends('student_layout')
@section('student_content')
<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item"><a href="/student/"><i class="fa fa-home" aria-hidden="true"></i></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Phản hồi</li>
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
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <h6 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách phản hồi</h6>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Bài kiểm tra</th>                          
                        <th>Phản hổi của bạn</th>
                        <th>Thời điểm phản hồi</th>
                        <th>Phản hồi của giảng viên</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($examfeedBack as $fb)
                        <tr>      
                            <td>{{$loop->index}}</td>        
                            <td>{{$fb->exam->title}}</td>   
                            <td>{{$fb->student_feedback}}</td> 
                            <td>{{\Carbon\Carbon::parse($fb->created_at)->format('d/m/Y')}}</td>                     
                            <td>
                                <div class="text-center">
                                    @if ($fb->teacher_rep =='')
                                        <span class="badge badge-danger">Chưa được trả lời</span>
                                    @else
                                        {{$fb->teacher_rep}}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                paging: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm..."
                }
            });
        });
    </script>    
@endsection