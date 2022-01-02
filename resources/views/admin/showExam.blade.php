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

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 border-bottom-0">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#list-exam" role="tab" aria-controls="nav-list-exam" aria-selected="true">
                    <h6 class="m-2 font-weight-bold text-primary d-inline-block">Bài kiểm tra đang chờ</h6>
                  </a>
                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#history-exam" role="tab" aria-controls="nav-history-exam" aria-selected="false">
                    <h6 class="m-2 font-weight-bold text-primary d-inline-block">Lịch sử kiểm tra</h6>
                  </a>
                </div>
              </nav>
        </div>
        <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
                {{-- list tab --}}
                <div class="tab-pane fade show active" id="list-exam" role="tabpanel" aria-labelledby="nav-list-exam">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable-listexam" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Số thứ tự</th>
                                    <th>Tên bài kiểm tra</th>
                                    <th>Lớp</th>
                                    <th>Tổng số câu hỏi</th>
                                    <th>Loại</th>
                                    <th>Thời gian làm bài</th>
                                    <th>Thời gian mở/đóng</th>
                                    <th>Trạng thái</th>
                                    <th>Xem chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exams as $ex)
                                    <tr>
                                        <td>{{$loop->index}}</td>                               
                                        <td>{{$ex->title}}</td>                  
                                        <td>{{$ex->cclass->class_name}}</td>
                                        <td>{{$ex->total_question}}</td>
                                        <td>
                                            @if ($ex->type == 'exam')
                                                Kiểm tra tính điểm
                                            @else
                                                Kiểm tra thử
                                            @endif
                                        </td>
                                        <td>{{$ex->duration}}</td>
                                        <td>
                                            Từ: <strong>{{$ex->time_open}}</strong> <br>
                                             đến: <strong>{{$ex->time_close}}</strong> 
                                        </td>
                                        <td class="text-center">
                                            @if(\Carbon\Carbon::parse($ex->time_open) < \Carbon\Carbon::now())
                                                <span class="badge badge-secondary">Đang kiểm tra</span> 
                                            @else
                                                <span class="badge badge-primary">Chuẩn bị kiểm tra</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <a href="{{URL::to('/admin/classExamResult/'.$ex->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- history tab --}}
                <div class="tab-pane fade" id="history-exam" role="tabpanel" aria-labelledby="nav-history-exam">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable-historyexam" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Số thứ tự</th>
                                    <th>Tên bài kiểm tra</th>
                                    <th>Lớp</th>
                                    <th>Tổng số câu hỏi</th>
                                    <th>Loại</th>
                                    <th>Thời gian làm bài</th>
                                    <th>Thời gian mở/đóng</th>
                                    <th>Xem chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hisExams as $he)
                                    <tr>
                                        <td>{{$loop->index}}</td>                               
                                        <td>{{$he->title}}</td>                  
                                        <td>{{$he->cclass->class_name}}</td>
                                        <td>{{$he->total_question}}</td>
                                        <td>
                                            @if ($he->type == 'exam')
                                                Kiểm tra tính điểm
                                            @else
                                                Kiểm tra thử
                                            @endif
                                        </td>
                                        <td>{{$he->duration}}</td>
                                        <td>
                                            @if ($he->type == 'exam')
                                                Từ: <strong>{{$he->time_open}}</strong> <br>
                                                đến: <strong>{{$he->time_close}}</strong> 
                                            @else
                                                Không
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <a href="{{URL::to('/admin/classExamResult/'.$he->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#dataTable-listexam').DataTable({
                paging: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm..."
                },
                "columnDefs": [ {
                "targets": [8],
                "orderable": false
                } ]
            });
            $('#dataTable-historyexam').DataTable({
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