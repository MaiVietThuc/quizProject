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
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Số bài kiểm tra</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$currTeacher->exam->count()}}</div>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Phản hổi bài kiểm tra</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$currTeacher->exam_feedback->count()}}</div>
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
<div class="row card-box shadow">
    <div class="col-lg-8 col-12 ">
        <h3 class="text-uppercase bg-light p-2 mt-0 mb-3">Thông tin cá nhân:</h3>
        <table class="table">
            <tr>
                <td>Tên:</td>
                <td>{{$currTeacher->name}}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{$currTeacher->email}}</td>
            </tr>
            <tr>
                <td>Giới tính:</td>
                <td>
                    @if ($currTeacher->gender ==1)
                        Nữ
                    @else
                        Nam
                    @endif
                </td>
            </tr>
            <tr>
                <td>Môn học phụ trách:</td>
                <td>
                    @foreach ($currTeacher->subject as $teachsub)
                        {{$teachsub->subject_name}} <br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td >Avatar: </td>
                <td>
                    @if (!empty($currTeacher->avatar))
                    <img src="{{asset($currTeacher->avatar)}}" alt="" height="100px" width="100px">
                    @else
                        <img src="{{asset('img/admin.jpg')}}" alt="" height="100px" width="100px">
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4 col-12"></div>
</div>
@endsection