@extends('admin_layout')

@section('admin_content')
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
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Quản trị viên phụ</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count['admin']}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-cog fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Giảng viên</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count['teacher']}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                               Sinh viên</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count['student']}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lớp học phần
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$count['class']}}</div>
                                </div>                               
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Bài kiểm tra</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count['exam']}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sticky-note fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Chuyên ngành</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count['majors']}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-table fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Phản hổi sinh viên</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Đã xem:      {{$count['seenFeedback']}} / {{$count['allFeedback']}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comment-dots fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- end card -->
@endsection