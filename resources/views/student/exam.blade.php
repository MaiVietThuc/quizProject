@extends('student_layout')

@section('student_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="/student/"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Làm bài kiểm tra</li>
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
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên bài kiểm tra</th>
                            <th>Thời gian</th>
                            <th>Lớp</th>
                            <th>Tổng số câu hỏi</th>
                            <th>Điểm tối đa</th>
                            <th>Loại</th>
                            <th>Thời gian mở/đóng</th>
                            <th>Trạng thái</th>
                            <th>Làm bài</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $ex)
                            <tr>     
                                <td>{{$loop->index}}</td>               
                                <td>{{$ex->title}}</td>                  
                                <td>{{$ex->duration}} Phút</td>
                                <td>{{$ex->cclass->class_name}}</td>
                                <td>{{$ex->total_question}}</td>
                                <td>{{$ex->total_marks}}</td>
                                <td>
                                    @if ($ex->type =='exam')
                                        Kiểm tra tính điểm
                                    @else
                                        Kiểm tra thử
                                    @endif

                                </td>
                                <td>
                                    @if ($ex->type == 'exam')
                                        Từ: <strong>{{$ex->time_open->format('H:i d/m/Y') }}</strong> <br>
                                        đến: <strong>{{$ex->time_close->format('H:i d/m/Y') }}</strong>                                       
                                    @else
                                        Không
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(\Carbon\Carbon::parse($ex->time_open) > (\Carbon\Carbon::now()))
                                        <span class="badge badge-info">Chuẩn bị kiểm tra</span><br>
                                    @elseif($ex->time_open =='')
                                    <span class="badge badge-info">Sẵn sàng</span><br>
                                    @else
                                        <span class="badge badge-danger">Đang kiểm tra</span> <br>
                                    @endif
                                    
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{URL::to('student/doExam/'.$ex->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-edit"></i></a>
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