@extends('student_layout')

@section('student_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="/student/"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử kiểm tra</li>
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
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên bài kiểm tra</th> 
                            <th>Thời gian</th>
                            <th>Loại</th>
                            <th>Ngày kiểm tra</th>
                            <th>Kết quả</th>
                            <th>Xem chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $ex)
                            <tr>     
                                <td>{{$loop->index}}</td>               
                                <td>{{$ex->exam->title}}</td>
                                <td>{{$ex->exam->duration}} Phút</td>
                                <td>
                                    @if ($ex->exam->type =='exam')
                                        Kiểm tra tính điểm
                                    @else
                                        Kiểm tra thử
                                    @endif

                                </td>
                                <td>
                                    @if ($ex->exam->type == 'exam')
                                        Từ: <strong>{{$ex->exam->time_open->format('H:i d/m/Y') }}</strong> <br>
                                        đến: <strong>{{$ex->exam->time_close->format('H:i d/m/Y') }}</strong>                                       
                                    @else
                                        <strong>{{$ex->time_start->format('d/m/Y')}}</strong>
                                    @endif
                                </td>
                                <td>{{$ex->mark}}/{{$ex->exam->total_marks}} điểm</td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{URL::to('student/resultDetail/'.$ex->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-eye"></i></a>
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
                "targets": [6],
                "orderable": false
                } ]
            });
        });
    </script>    
@endsection