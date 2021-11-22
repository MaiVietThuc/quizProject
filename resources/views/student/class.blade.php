@extends('student_layout')

@section('student_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="/student/"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Lớp đang học</li>
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
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách lớp học</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID lớp</th>
                            <th>Tên lớp</th>
                            <th>Môn học</th>
                            <th>Sĩ số</th>
                            <th>Bài kiểm tra</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($class as $tc)
                            <tr>
                                <td>CLS-{{$tc->id}}</td>                               
                                <td>{{$tc->class_name}}</td>                  
                                <td>{{$tc->subject->subject_name}}</td>
                                <td>{{$tc->class_student->count()}}</td>
                                <td>
                                    Tổng: <strong>{{$tc->exam->count()}}</strong>
                                </td>
                                <td>
                                    Từ: <strong>{{$tc->date_open->format('d/m/Y') }}</strong> <br>
                                     đến: <strong>{{$tc->date_close->format('d/m/Y') }}</strong> 
                                </td>
                                <td class="text-center">
                                    @if(\Carbon\Carbon::parse($tc->date_open) > \Carbon\Carbon::now())
                                        <span class="badge badge-secondary">Chuẩn bị</span> 
                                    @else
                                        <span class="badge badge-primary">Đang học</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{URL::to('/student/class/manager/'.$tc->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-eye"></i></a>
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
                "targets": [7],
                "orderable": false
                } ]
            });
        });
    </script>    
@endsection