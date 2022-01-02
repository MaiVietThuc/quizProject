@extends('teacher_layout')
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
    
@endsection
@section('teacher_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="/teacher/"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="{{URL::to('/teacher/class/')}}">Lớp phụ trách</a>
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
        {{-- <h3 class="text-uppercase bg-light p-2 mt-0 mb-3">Thông tin lớp học:</h3> --}}
        <div class="col-lg-6 col-12 ">
            <table class="table">
                <tr>
                    <td>Mã lớp</td>
                    <td>{{$classinf->class_code}}</td>
                </tr>
                <tr>
                    <td>Tên lớp:</td>
                    <td>{{$classinf->class_name}}</td>
                </tr>
                <tr>
                    <td>Sĩ số:</td>
                    <td>{{$classinf->student->count()}}</td>
                </tr>
                <tr>
                    <td>Môn học:</td>
                    <td>{{$classinf->subject->subject_name}}</td>
                </tr>
                <tr>
                    <td>Thời gian:</td>
                    <td>
                       Từ: {{$classinf->date_open->format('d/m/Y')}} Đến: {{$classinf->date_close->format('d/m/Y')}}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-6 col-12">
            <table class="table">
                <tr>
                    <td>Bài kiểm tra:</td>
                    <td>
                        {{-- Tổng:{{$classinf->exam->count()}} <br> --}}
                        @foreach ($classinf->exam as $ex)
                            @if($ex->type=='exam')
                                @if((\Carbon\Carbon::parse($ex->date_open)) > (\Carbon\Carbon::now()))
                                    <a href="{{URL::to('teacher/exam/classExamResult/'.$ex->id)}}">
                                        {{$ex->title}}<span class="badge badge-secondary ml-2">Chưa kiểm tra</span><br>
                                    </a>
                                @else
                                    <a href="{{URL::to('teacher/exam/classExamResult/'.$ex->id)}}">
                                        {{$ex->title}}<span class="badge badge-success ml-2">Đã kiểm tra</span><br>
                                    </a>
                                @endif
                            @else
                                <a href="{{URL::to('teacher/exam/classExamResult/'.$ex->id)}}">    
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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>MSSV</th>
                        <th>Tên</th>
                        <th>Avatar</th>
                        <th>Email</th>
                        <th>Giới tính</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classinf->student as $st)
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
                                @if ($st->gender==0)
                                    Nam
                                @else
                                    Nữ
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <a onclick="deleteConfirm()" href="{{URL::to('/teacher/class/deleteClassStudent/'.$classinf->id.'/'.$st->id.'')}}" class="action-icon text-secondary mr-2" style="font-size: 25px;"><i class="far fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

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
    </script>    
@endsection