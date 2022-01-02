@extends('admin_layout')

@section('admin_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('/admin/class')}}">Quản lý lớp học phần</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm lớp</li>
        </ol>
    </nav>
    @if(count($errors) > 0)
        @foreach ($errors->all() as $err)
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$err}}       
            </div>
        @endforeach
    @endif
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{session('success')}}!
        </div>
    @endif
    <!-- mainform -->
    <form class="" action="{{URL::to('/admin/postAddClass')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card-box shadow col-10 ml-5  pt-3 pb-3">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Thêm lớp học</h5>
                    
                    <div class="form-group mb-3">
                        <label for="product-name">Mã lớp:<span class="text-danger">*</span></label>
                        <input type="text" id="mcn" name="class_code" class="form-control" placeholder="Mã lớp">
                    </div>

                    <div class="form-group mb-3">
                        <label for="product-name">Tên lớp:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tên lớp">
                    </div>

                    <div class="form-group mb-3">
                        <label for="class">Môn học:<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="subject" id="subject">
                            @foreach ($subjects as $sj)   
                                <option value="{{$sj->id}}">{{$sj->subject_name}}</option>             
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="class">Giảng viên phụ trách:<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="teacher" id="teacher">
                            @foreach ($teacher as $tc)   
                                <option value="{{$tc->id}}">{{$tc->name}}</option>             
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="duration">Ngày mở:<span class="text-danger">*</span></label>
                        <input type="date" id="date_open" name="date_open" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="duration">Ngày kết thúc:<span class="text-danger">*</span></label>
                        <input type="date" id="date_close" name="date_close" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-2">Trạng thái</label>
                        <br/>
                        <div class="radio form-check-inline mr-4">
                            <label for="inlineRadio1">
                                <input type="radio" id="inlineRadio1" value="1" name="status" checked=""> 
                                Khả dụng:
                            </label>
                        </div>
                        <div class="radio form-check-inline">
                            <label for="inlineRadio2">
                                <input type="radio" id="inlineRadio2" value="0" name="status">
                                 Ẩn:
                            </label>
                        </div>
                
                    </div>

                    <div class="text-center mb-3" >
                        <a onclick="cancelConfirm()" href="{{URL::to('/admin/majors')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>

                </div> <!-- end card-box -->
            </div> <!-- end col -->
            <div class="col-lg-3"></div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        window.onbeforeunload = function() {
            return "";
        }
    </script>
@endsection