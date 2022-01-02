@extends('admin_layout')
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
    
@endsection
@section('admin_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/class/')}}">Lớp học</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý lớp</li>
        </ol>
    </nav>
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
    <div class="row card-box shadow  p-3 mb-1 ml-1 mr-1">
        <div class="col-lg-6 col-12 ">
            <table class="table">
                <tr>
                    <td>Mã lớp</td>
                    <td>{{$class->class_code}}</td>
                </tr>
                <tr>
                    <td>Tên lớp:</td>
                    <td>{{$class->class_name}}</td>
                </tr>
                <tr>
                    <td>Sĩ số:</td>
                    <td>{{$class->student->count()}}</td>
                </tr>
                <tr>
                    <td>Môn học:</td>
                    <td>{{$class->subject->subject_name}}</td>
                </tr>
                <tr>
                    <td>Thời gian:</td>
                    <td>
                       Từ: {{$class->date_open->format('d/m/Y')}} Đến: {{$class->date_close->format('d/m/Y')}}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-6 col-12">
            <table class="table">
                <tr>
                    <td>Bài kiểm tra:</td>
                    <td>
                        @foreach ($class->exam as $ex)
                            @if($ex->type=='exam')
                                @if((\Carbon\Carbon::parse($ex->date_open)) > (\Carbon\Carbon::now()))
                                    <a href="{{URL::to('admin/classExamResult/'.$ex->id)}}">
                                        {{$ex->title}}<span class="badge badge-secondary ml-2">Chưa kiểm tra</span><br>
                                    </a>
                                @else
                                    <a href="{{URL::to('admin/classExamResult/'.$ex->id)}}">
                                        {{$ex->title}}<span class="badge badge-success ml-2">Đã kiểm tra</span><br>
                                    </a>
                                @endif
                            @else
                                <a href="{{URL::to('admin/classExamResult/'.$ex->id)}}">    
                                    {{$ex->title}}<span class="badge badge-success ml-2">Kiểm tra thử</span><br>
                                </a>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <div class="card shadow mb-4 p-2">
        <div class="table-responsive">
            <h4 class="text-uppercase p-2 mt-0 mb-1">Danh sách sinh viên:</h4>
            <div class="dropdown d-inline-block float-left mt-1 mr-1">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-plus"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div class=" d-flex flex-column">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudent">
                            <i class="fas fa-pen pr-2"></i>Thêm
                        </button>
                        <a class="dropdown-item pt-2 pb-2" href="javascript:void(0)" id="exel-import-a"><i class="fas fa-file-excel pr-2"></i>Thêm
                            bằng exel </a>
                        <input type="file" id="exel-input" class="d-none">
                    </div>
                </div>
            </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>MSSV</th>
                        <th>Tên</th>
                        <th>Avatar</th>
                        <th>Email</th>
                        <th>Chuyên ngành</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($class->student as $st)
                        <tr>
                            <td>{{$loop->index}}</td>                               
                            <td>{{$st->student_code}}</td>                               
                            <td>{{$st->name}}</td>                                           
                            @if ($st->avatar !='')
                                <td class="text-center" ><img src="{{asset($st->avatar)}}" alt="" width="35px" height="35px"></td>
                            @else
                            <td class="text-center" ><img src="{{asset('/img/user.png')}}" alt="" width="35px" height="35px"></td>
                            @endif                      
                            <td>{{$st->email}}</td>
                            <td>
                                {{$st->majors->name}}
                            </td>
                            <td>
                                <div class="text-center">
                                    <a onclick="deleteConfirm()" href="{{URL::to('/admin/deleteClassStudent/'.$class->id.'/'.$st->id.'')}}" class="action-icon text-secondary mr-2" style="font-size: 25px;"><i class="far fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade pt-4" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="addStudent" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content mt-4">
                <form class="" action="{{URL::to('admin/class/addStudent/'.$class->id.'')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Thêm Sinh viên</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <h3>Danh sách sinh viên</h3>

                        <div class="mb-3">
                            <table class="table table-bordered" id="table_addStudent" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>MSSV</th>
                                        <th>Tên</th>
                                        <th>Avatar</th>
                                        <th>Email</th>
                                        <th>Chuyên ngành</th>
                                        <th>Chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($student as $st)
                                    <tr>
                                        <td>{{$st->student_code}}</td>                               
                                        <td>{{$st->name}}</td>                                           
                                        @if ($st->avatar !='')
                                            <td class="text-center" ><img src="{{asset($st->avatar)}}" alt="" width="35px" height="35px"></td>
                                        @else
                                        <td class="text-center" ><img src="{{asset('/img/user.png')}}" alt="" width="35px" height="35px"></td>
                                        @endif                      
                                        <td>{{$st->email}}</td>
                                        <td>
                                            {{$st->majors->name}}
                                        </td>
                                        <td class="text-center">
                                            <label for="checkbox{{$loop->index}}" style="width: 100%;height: 100%;">                               
                                                <input type="checkbox" name="student[]" value="{{$st->id}}" id="checkbox{{$loop->index}}" class="mt-2" style="width: 1.5rem;height:1.5rem;">
                                            </label>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal --}}
@endsection

@section('script')
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                paging: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm...",
                    search: ""
                },
                "columnDefs": [ {
                "targets": [6],
                "orderable": false
                }],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Xuất excel',
                        exportOptions: {
                            columns: [0,1,2,4,5]
                        }
                    }
                ]
            });
        });
        $(document).ready(function () {
            $('#table_addStudent').DataTable({
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm...",
                    search: ""
                },
                "columnDefs": [ {
                "targets": [5],
                "orderable": false
                }]
            });
        });
    </script>    
@endsection