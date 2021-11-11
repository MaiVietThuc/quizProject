@extends('admin_layout')

@section('admin_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý phản hồi</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-5 text-gray-800 pl-3">Quản lý phản hồi</h1>
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
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách phản hồi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã số sinh viên</th>
                            <th>Tên sinh viên</th>                          
                            <th>Chủ đề</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feedbacks as $fb)
                            <tr>
                                <td>fb-{{$fb->student_id}}</td>                               
                                <td>Tên sv</td>                  
                                <td>{{$fb->problem}}</td>   
                                <td>{{$fb->problem_content}}</td>                           
                                <td>
                                    <div class="text-center">
                                        @if ($fb->status ==1)
                                            <p class="text-success">Đã đọc</p>
                                        @else
                                        <p class="text-danger">Chưa đọc</p>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-edit"></i></a>
                                        <a onclick="deleteConfirm()" href="{{URL::to('admim/delete/feedback/'.$fb->id.'')}}" class="action-icon text-danger" style="font-size: 25px;"><i class="far fa-trash"></i></a>
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
                "targets": [3],
                "orderable": false
                } ]
            });
        });
    </script>    
@endsection