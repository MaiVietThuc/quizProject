@extends('admin_layout')

@section('admin_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý chuyên ngành</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-5 text-gray-800 pl-3">Quản lý chuyên ngành</h1>
    @if (Session('complete'))
        <div class="alert alert-success alert-dismissible text-center position-fixed" id="bt-alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{session('complete')}}!
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách chyên ngành</h5>
            <!-- button -->
            <div class="wrap d-inline-block float-right">
                <a class="dropdown-item pt-2 pb-2" href="{{URL::to('admin/getAddMajors')}}"><i class="fas fa-pen pr-2"></i>Thêm</a>
            </div>
            <!-- end button -->
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã số chuyên ngành</th>
                            <th>Tên chuyên ngành</th>                          
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($majors as $major)
                            <tr>
                                <td>major-{{$major->majors_code}}</td>                               
                                <td>{{$major->name}}</td>                                                
                                <td>
                                    <div class="text-center">
                                        @if ($major->status ==1)
                                            <a class="badge bg-soft-success text-primary m-0 p-0" href="{{URL::to('admin/changeMajorsStatus/'.$major->id.'/off')}}" style="font-size: 35px;"><i class="fas fa-toggle-on"></i></a>
                                        @else
                                            <a class="badge text-danger m-0 p-0" href="{{URL::to('admin/changeMajorsStatus/'.$major->id.'/on')}}" style="font-size: 35px;"><i class="fas fa-toggle-off"></i></i></a> 
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-edit"></i></a>
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
                "targets": [3],
                "orderable": false
                } ]
            });
        });
    </script>    
@endsection