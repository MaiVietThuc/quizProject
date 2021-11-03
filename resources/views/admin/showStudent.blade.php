@extends('admin_layout')

@section('admin_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý sinh viên</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-5 text-gray-800 pl-3">Quản lý sinh viên</h1>
    @if (Session('complete'))
        <div class="alert alert-success alert-dismissible text-center position-fixed" id="bt-alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{session('complete')}}!
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách sinh viên</h5>
            <!-- button -->
            <div class="wrap d-inline-block float-right">
                <div class="dropdown d-inline-block mt-1 mr-1">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-plus"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item pt-2 pb-2" href="{{URL::to('/admin/getAddStudent')}}"><i class="fas fa-pen pr-2"></i>Thêm thủ
                            công</a>
                        <a class="dropdown-item pt-2 pb-2" href="javascript:void(0)" id="exel-import-a"><i class="fas fa-file-excel pr-2"></i>Thêm
                            bằng exel </a>

                        <input type="file" id="exel-input" class="d-none">
                    </div>
                </div>
                <script>
                    document.getElementById('exel-import-a').addEventListener('click', () => {
                        document.getElementById('exel-input').click()
                    });
                </script>
                <button class="btn btn-light mt-1" type="button">
                    <i class="fas fa-file-excel pr-2"></i>Xuất file exel
                </button>
            </div>
            <!-- end button -->
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>MSSV</th>
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>email</th>
                            <th>Giới tính</th>
                            <th>Chuyên ngành</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{$student->student_code}}</td>
                                
                                @if (empty($student->avatar))
                                    <td class="text-center" ><img src="{{asset('/img/user.png')}}" alt="" width="35px" height="35px"></td>
                                @else
                                    <td class="text-center" ><img src="{{asset($student->avatar)}}" alt="" width="35px" height="35px"></td>
                                @endif

                                <td>{{$student->name}}</td>
                                <td>{{$student->email}}</td>
                                @if ($student->gender ==0)
                                    <td>Nam</td> 
                                @else
                                    <td>Nữ</td> 
                                @endif
                                <td>{{$student->majors->name}}</td>
                                <td>
                                    <div class="text-center">
                                        @if ($student->status ==1)
                                            <a class="badge bg-soft-success text-primary m-0 p-0" href="{{URL::to('/admin/changeStudentStatus/'.$student->id.'/off')}}" style="font-size: 35px;"><i class="fas fa-toggle-on"></i></a>
                                        @else
                                            <a class="badge text-danger m-0 p-0" href="{{URL::to('/admin/changeStudentStatus/'.$student->id.'/on')}}" style="font-size: 35px;"><i class="fas fa-toggle-off"></i></i></a> 
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{URL::to('/admin/getEditStudent/'.$student->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-edit"></i></a>
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