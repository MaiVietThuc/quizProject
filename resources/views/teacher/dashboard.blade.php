@extends('teacher_layout')

@section('teacher_content')
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
            <div class="card border-left-info shadow h-100 py-2">
                <a href="{{URL::to('teacher/class')}}" class="text-decoration-none">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lớp phụ trách
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$currTeacher->cclass->count()}}</div>
                                    </div>                               
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <a href="{{URL::to('teacher/exam/history')}}" class="text-decoration-none">    
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Bài kiểm tra đang soạn</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$exams}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sticky-note fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <a href="{{URL::to('teacher/exam/history')}}" class="text-decoration-none">    
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Số bài kiểm tra</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$currTeacher->exam->count()}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sticky-note fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <a href="{{URL::to('teacher/feedback')}}" class="text-decoration-none">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Phản hổi bài kiểm tra</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$feedbackNotRep}}/{{$feedback}} chưa phản hồi</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comment-dots fa-4x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
<!-- end card -->
@endsection