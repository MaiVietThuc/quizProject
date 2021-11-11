@extends('admin_layout')

@section('admin_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý lớp học phần</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-5 text-gray-800 pl-3">Quản lý lớp học phần</h1>
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
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách lớp</h5>
            <!-- button -->
            <div class="wrap d-inline-block float-right">
                <a class="dropdown-item pt-2 pb-2" href="#"><i class="fas fa-pen pr-2"></i>Thêm</a>
            </div>
            <!-- end button -->
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID lớp</th>
                            <th>Tên lớp</th>
                            <th>Giảng viên phụ trách</th>
                            <th>Môn học</th>
                            <th>Số sinh viên</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($class as $cls)
                            <tr>
                                <td>CLS-{{$cls->id}}</td>                               
                                <td>{{$cls->class_name}}</td>                  
                                <td>{{$cls->teacher->name}}</td>
                                <td>{{$cls->subject->subject_name}}</td>
                                <td>{{$cls->student->count()}}</td>
                                <td>
                                    <div class="text-center">
                                        @if ($cls->status ==1)
                                            <a class="badge bg-soft-success text-primary m-0 p-0" href="{{URL::to('admin/changeClassStatus/'.$cls->id.'/off')}}" style="font-size: 35px;"><i class="fas fa-toggle-on"></i></a>
                                        @else
                                            <a class="badge text-danger m-0 p-0" href="{{URL::to('admin/changeClassStatus/'.$cls->id.'/on')}}" style="font-size: 35px;"><i class="fas fa-toggle-off"></i></i></a> 
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{URL::to('admin/getEditClass/'.$cls->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-edit"></i></a>
                                        <a onclick="deleteConfirm()" href="{{URL::to('admin/delete/class/'.$cls->id.'')}}" class="action-icon text-danger" style="font-size: 25px;"><i class="far fa-trash"></i></a>
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