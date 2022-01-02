@extends('teacher_layout')

@section('teacher_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="/teacher/"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Bài kiểm tra</li>
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách bài kiểm tra</h5>
            <!-- button -->
            <div class="wrap d-inline-block float-right">
                <a class="dropdown-item pt-2 pb-2" href="{{URL::to('teacher/exam/addExam')}}"><i class="fas fa-pen pr-2"></i>Thêm</a>
            </div>
            <!-- end button -->
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Số thứ tự</th>
                            <th>Tên bài kiểm tra</th>
                            <th>Thời gian làm bài</th>
                            <th>Lớp</th>
                            <th>Tổng số câu hỏi</th>
                            <th>Loại</th>
                            <th>Thời gian mở/đóng</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $ex)
                            <tr>            
                                <td>{{$loop->index}}</td>                   
                                <td>{{$ex->title}}</td>                  
                                <td>{{$ex->duration}} Phút</td>
                                <td>{{$ex->cclass->class_name}}</td>
                                <td>
                                    @if ($ex->total_question =='')
                                    0
                                    @else
                                    {{$ex->total_question}}
                                    @endif
                                </td>
                                <td>{{$ex->type}}</td>
                                <td>
                                    @if ($ex->type == 'exam')
                                        Từ: <strong>{{$ex->time_open->format('H:i d/m/Y') }}</strong> <br>
                                        đến: <strong>{{$ex->time_close->format('H:i d/m/Y') }}</strong>                                       
                                    @else
                                        Không
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($ex->status ==1)
                                        <span class="badge badge-success">Soạn xong</span><br>
                                        {{-- <a class="badge bg-soft-success text-primary m-0 p-0" href="{{URL::to('teacher/exam/changeStatus/'.$ex->id.'/off')}}" style="font-size: 35px;"><i class="fas fa-toggle-on"></i></a> --}}
                                    @else
                                        <span class="badge badge-secondary text-info">Đang soạn</span> <br>
                                        {{-- <a class="badge text-danger m-0 p-0" href="{{URL::to('teacher/exam/changeStatus/'.$ex->id.'/on')}}" style="font-size: 35px;"><i class="fas fa-toggle-off"></i></i></a>  --}}
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{URL::to('teacher/exam/getManagerExam/'.$ex->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-edit"></i></a>
                                        <a onclick="deleteConfirm()" href="{{URL::to('teacher/exam/deleteExam/'.$ex->id.'')}}" class="action-icon text-danger" style="font-size: 25px;"><i class="far fa-trash"></i></a>
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
                },
                "columnDefs": [ {
                "targets": [8],
                "orderable": false
                } ]
            });
        });
    </script>    
@endsection