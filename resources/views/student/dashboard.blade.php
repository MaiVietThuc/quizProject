@extends('student_layout')

@section('student_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
          <li class="breadcrumb-item active"><a href="#"><i class="fa fa-home" aria-hidden="true"></i> Tổng quan</a></li>
        </ol>
      </nav>

    <!-- main content -->
    <div class="row">
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
    <!-- card dashboard -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <a class="text-decoration-none" href="{{URL::to('student/exam')}}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Bài kiểm tra đang chờ</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$exams}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sticky-note fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <a class="text-decoration-none" href="{{URL::to('student/historyExam')}}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Bài kiểm tra đã hoàn thành</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usedExam}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sticky-note fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <a class="text-decoration-none" href="{{URL::to('student/class')}}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lớp học
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$allClass}}</div>
                                    </div>                               
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <a class="text-decoration-none" href="javascript:void(0)">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Điển trung bình</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$avgMark}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sticky-note fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <a class="text-decoration-none" href="{{URL::to('student/feedback')}}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Thông tin phản hồi của bạn</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$examFeedBack}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comment-dots fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<!-- end card -->
@endsection