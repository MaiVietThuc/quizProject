@extends('teacher_layout')

@section('teacher_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('/teacher/exam')}}">Quản lý bài kiểm tra</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm bài kiểm tra</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 pl-3">Thêm bài kiểm tra</h1>
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
    <form class="" action="{{URL::to('/teacher/exam/postAddExam')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card-box shadow col-10 ml-5  pt-3 pb-3">
                    
                    <div class="form-group mb-3">
                        <label for="name">Tên bài kiểm tra:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tên bài kiểm tra">
                    </div>

                    <div class="form-group mb-3">
                        <label for="class">Lớp:<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="class" id="class">
                            @foreach ($currTeacher->cclass as $cl)   
                                <option value="{{$cl->id}}">{{$cl->class_name}}</option>             
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                            <label for="duration">Thời gian làm bài:<span class="text-danger">*</span></label>
                            <input type="number" id="duration" name="duration" class="form-control" placeholder="Thời gian làm bài (phút)">
                    </div>
                   
                    <div class="form-group mb-3">
                        <label class="mb-2">Loại bài kiểm tra:<span class="text-danger">*</span></label>
                        <br/>
                        <div class="radio form-check-inline mr-4">
                            <label for="inlineRadio1">
                                <input type="radio" id="inlineRadio1" value="exam" name="type" checked=""> 
                                Kiểm tra thường:
                            </label>
                        </div>
                        <div class="radio form-check-inline">
                            <label for="inlineRadio2">
                                <input type="radio" id="inlineRadio2" value="exam_test" name="type">
                                 Kiểm tra thử:
                            </label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                            <label for="time_open">Thời gian mở đề:</span></label>
                            <input type="datetime-local" id="time_open" name="time_open" class="form-control" placeholder="Thời gian mở đề">
                    </div>

                    <div class="text-center mb-3" >
                        <a onclick="cancelConfirm()" href="{{URL::to('/teacher/student')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
            
            </div> <!-- end col -->

            <div class="col-lg-3"></div>
        </div>
    </form>
@endsection

@section('script')
<script>
    const time_open = document.getElementById('time_open');
    const inlineRadio2 = document.getElementById('inlineRadio2');
    const inlineRadio1 = document.getElementById('inlineRadio1');
    inlineRadio2.addEventListener('change',function(){
        if(this.checked){
            time_open.disabled = true;
        }
    });
    inlineRadio1.addEventListener('change',function(){
        if(this.checked){
            time_open.disabled = false;
        }
    });
</script>
@endsection