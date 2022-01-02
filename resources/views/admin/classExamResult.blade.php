@extends('admin_layout')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
@endsection
@section('admin_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="/teacher/"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/exam')}}">Lịch sử kiểm tra</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{$examInfo->title}}</li>
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
    <h6 class="text-uppercase bg-light p-2 mt-0 mb-3">Thông tin bài kiểm tra</h6>
    <div class="row card-box shadow  p-3 mb-1 ml-1 mr-1">
        <div class="col-lg-6 col-12 ">
            <table class="table">
                <tr>
                    <td>Tên bài kiểm tra</td>
                    <td id="examTitle">{{$examInfo->title}}</td>
                </tr>
                <tr>
                    <td>Tên lớp</td>
                    <td>{{$examInfo->cclass->class_name}}</td>
                </tr>
                <tr>
                    <td>Ngày kiểm tra</td>
                    @if(is_null($examInfo->time_open))
                    <td>Không</td> 
                    @else
                        <td>Từ {{$examInfo->time_open->format('H:i d/m/Y')}} đến {{$examInfo->time_close->format('H:i d/m/Y')}}</td>
                    @endif
                </tr>
                <tr>
                    <td>Thời gian kiểm tra</td>
                    <td>{{$examInfo->duration}}</td>
                </tr>
            </table>
        </div>
        <div class="col-lg-6 col-12">
            <table class="table">
                <tr>
                    <td>Tổng số câu hỏi</td>
                    <td>
                    Từ: {{$examInfo->total_question}}
                    </td>
                </tr>
                <tr>
                    <td>Điểm tối đa</td>
                    <td>{{$examInfo->total_marks}}</td>
                </tr>
                <tr>
                    <td>Loại bài kiểm tra</td>
                    <td>@if($examInfo->type=='exam')Kiểm tra @else Kiểm tra thử @endif</td>
                </tr>
                <tr>
                    <td>
                        <a href="{{URL::to('/admin/showExamQuestion/'.$examInfo->id)}}">Chi tiết bài kiểm tra</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{-- end exam-info --}}
    <hr>
    <div class="card shadow mb-4 p-2">
        <div class="table-responsive">
            <h3 class="text-uppercase p-2 mt-0 mb-3">Danh sách điểm:</h3>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>MSSV</th>
                        <th>Avatar</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Điểm</th>
                        <th>Thời gian làm bài</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classExamResult as $cer)
                        <tr>                          
                            <td>{{$cer->student->student_code}}</td>                               
                                @if ($cer->student->avatar !='')
                                    <td class="text-center" ><img src="{{asset($cer->student->avatar)}}" alt="" width="35px" height="35px"></td>
                                @else
                                    <td class="text-center" ><img src="{{asset('/img/user.png')}}" alt="" width="35px" height="35px"></td>
                                @endif                      
                            <td>{{$cer->student->name}}</td>                                           
                            <td>{{$cer->student->email}}</td>
                            <td>
                                <strong>{{$cer->mark}}</strong>
                            </td>
                            <td>
                                Từ: <strong>{{$cer->time_start->format('H:m:i')}}</strong> đến <strong>{{$cer->time_end->format('H:m:i')}}</strong> 
                                ngày <strong>{{$cer->time_end->format('d/m/Y')}}</strong>
                            </td>
                            <td class="text-center">
                                <a href="{{URL::to('admin/studentExamResultDetail/'.$cer->student->id.'&'.$examInfo->id)}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-eye"></i></a>
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
        const examTitle = document.getElementById('examTitle').textContent;
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
                }],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Xuất excel',
                        messageTop: examTitle,
                        exportOptions: {
                            columns: [0,2,3,4]
                        }
                    }
                ]
            });
        });
    </script>    
@endsection