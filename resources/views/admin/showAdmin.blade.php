@extends('admin_layout')

@section('admin_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý admin</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-5 text-gray-800 pl-3">Quản lý admin</h1>
    @if (Session('complete'))
        <div class="alert alert-success alert-dismissible text-center position-fixed" id="bt-alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{session('complete')}}!
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách admin</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID admin</th>
                            <th>Avatar</th> 
                            <th>Tên admin</th>                          
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Trạng thái</th>
                            <th>hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $adm)
                            <tr>
                                <td>adm-{{$adm->id}}</td>
                                @if (empty($adm->avatar))
                                    <td><img src="{{asset('/img/user.png')}}" alt="" width="35px" height="35px"></td>   
                                @else
                                    <td><img src="{{asset($adm->avatar)}}" alt="" width="35px" height="35px"></td>
                                @endif                               
                                               
                                <td>{{$adm->name}}</td>   
                                <td>{{$adm->email}}</td>
                                <td>{{$adm->role_id}}</td>                         
                                <td>
                                    <div class="text-center">
                                        @if ($adm->status ==1)
                                        <a class="badge bg-soft-success text-primary m-0 p-0" href="{{URL::to('admin/changeAdminStatus/'.$adm->id.'/off')}}" style="font-size: 35px;"><i class="fas fa-toggle-on"></i></a>
                                    @else
                                        <a class="badge text-danger m-0 p-0" href="{{URL::to('admin/changeAdminStatus/'.$adm->id.'/on')}}" style="font-size: 35px;"><i class="fas fa-toggle-off"></i></i></a> 
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