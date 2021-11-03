@extends('admin_layout')

@section('admin_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý bài kiểm tra</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-5 text-gray-800 pl-3">Quản lý bài kiểm tra</h1>
    @if (Session('complete'))
        <div class="alert alert-success alert-dismissible text-center position-fixed" id="bt-alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{session('complete')}}!
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
                            <th>ID bài</th>
                            <th>Tên bài kiểm tra</th>
                            <th>Lớp</th>
                            <th>Tổng điểm</th>
                            <th>Thời gian mở đề</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $exam)
                            <tr>
                                <td>ex-{{$exam->id}}</td>                               
                                <td>{{$exam->title}}</td>                  
                                <td>K3TH2</td>
                                <td>{{$exam->total_marks}} điểm</td>
                                <td>{{$exam->dateTime_Open}}</td>
                                <td>
                                    <div class="text-center">
                                        @if ($exam->status ==1)
                                            <p class="text-sucess">Đã kiểm tra</p>
                                        @else
                                            <p class="text-danger">Chưa kiểm tra</p>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-eye"></i></a>
                                        <a href="" class="action-icon text-danger" style="font-size: 25px;"><i class="far fa-trash"></i></a>
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