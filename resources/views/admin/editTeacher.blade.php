@extends('admin_layout')

@section('admin_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/')}}"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('/admin/teacher')}}">Quản lý giảng viên</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa giảng viên</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 pl-3">Sửa giảng viên</h1>
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
    <form class="" action="{{URL::to('/admin/postEditTeacher/'.$teacher->id.'')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card-box shadow col-10 ml-5  pt-3 pb-3">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Bắt buộc</h5>

                    <div class="form-group mb-3">
                        <label for="product-name">Tên giảng viên:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tên giảng viên" value="{{$teacher->name}}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="product-summary">Email:</label>
                        <input class="form-control" name="email"  rows="2" placeholder="email" autocomplete="false" value="{{$teacher->email}}">
                    </div>

                    <div class="form-group mb-3">
                            <label for="product-category">Giới tính:<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="gender" id="gender">
                                @if ($teacher->gender ==0)
                                    <option selected value="0">Nam</option>
                                    <option value="1">Nữ</option>
                                @else
                                    <option selected value="1">Nữ</option>
                                    <option value="0">Nam</option>
                                @endif     
                            </select>
                    </div>             

                    <div class="form-group mb-3">
                        <div class="radio form-check mr-4 pl-0 mt-4">
                            <label for="changepw">
                                <input type="checkbox" id="changepw" value="1" name="changepw"> 
                                Đổi mật khẩu
                            </label>
                        </div>   
                        <label for="product-reference">Mật khẩu:<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge" id="form-password">                                            
                            <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" autocomplete="false" disabled>                                  
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href=""><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="product-reference">Xác nhật mật khẩu:<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge" id="form-confirm-pw">
                            <input type="password"  name="password_confirmation" id="password-confirm" class="form-control" placeholder="Xác nhận mật khẩu" autocomplete="false" disabled>
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href=""><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-box -->
            </div> <!-- end col -->

            <div class="col-lg-6">

                <div class="card-box shadow col-10  mr-5 pt-3 pb-3">
                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Thông tin tùy chọn</h5>                   

                    
                    <div class="form-group mb-3">
                        <label class="mb-2">Môn giảng dạy</label>
                        <div class="form-control"  style="height: 11rem;overflow-y: scroll;">
                            @foreach ($teach_subj as $ts)
                                <input type="checkbox" id="subject_{{$ts->id}}" name="subjects[]" value="{{$ts->id}}" checked>
                                <label class="mb-0 pb-2" style="width:90%" for="subject_{{$ts->id}}">{{$ts->subject_name}}</label><br>
                            @endforeach
                            @foreach ($subjects as $sb)
                                <input type="checkbox" id="subject_{{$sb->id}}" name="subjects[]" value="{{$sb->id}}">
                                <label class="mb-0 pb-2" style="width:90%" for="subject_{{$sb->id}}">{{$sb->subject_name}}</label><br>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="fallback">
                            <label for="image1">Ảnh đại diện<span class="text-danger"> : </span></label><br>
                            @if ($teacher->avatar!='')
                                <img src="{{asset($teacher->avatar)}}" alt="" width="35px" height="35px">
                            @else
                                <img src="{{asset('img/user.png')}}" alt="" width="35px" height="35px">
                            @endif
                            <input  name="avatar" type="file" rows="3" id="avatar"/>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-2">Trạng thái</label>
                        <br/>
                        <div class="radio form-check-inline mr-4">
                            <label for="inlineRadio1">
                                @if($teacher->status==1)
                                <input type="radio" id="inlineRadio1" value="1" name="status" checked> 
                                @else
                                <input type="radio" id="inlineRadio1" value="0" name="status" > 
                                @endif
                                Khả dụng:
                            </label>
                        </div>
                        <div class="radio form-check-inline">
                            <label for="inlineRadio2">
                                @if($teacher->status==0)
                                <input type="radio" id="inlineRadio1" value="0" name="status" checked> 
                                @else
                                <input type="radio" id="inlineRadio1" value="1" name="status" > 
                                @endif
                                 Ẩn:
                            </label>
                        </div>
                
                    </div>

                    <div class="text-center mb-3" >
                        <a onclick="cancelConfirm()" href="{{URL::to('/admin/teacher')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>


                </div>

            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#form-password a").on('click', function(event) {
                event.preventDefault();
                if($('#form-password input').attr("type") == "text"){
                    $('#form-password input').attr('type', 'password');
                    $('#form-password i').addClass( "fa-eye" );
                    $('#form-password i').removeClass( "fa-eye-slash" );
                }else if($('#form-password input').attr("type") == "password"){
                    $('#form-password input').attr('type', 'text');
                    $('#form-password i').removeClass( "fa-eye" );
                    $('#form-password i').addClass("fa-eye-slash");
                }
            });
            
            $("#form-confirm-pw a").on('click', function(event) {
                event.preventDefault();
                if($('#form-confirm-pw input').attr("type") == "text"){
                    $('#form-confirm-pw input').attr('type', 'password');
                    $('#form-confirm-pw i').addClass( "fa-eye" );
                    $('#form-confirm-pw i').removeClass( "fa-eye-slash" );
                }else if($('#form-password input').attr("type") == "password"){
                    $('#form-confirm-pw input').attr('type', 'text');
                    $('#form-confirm-pw i').removeClass( "fa-eye" );
                    $('#form-confirm-pw i').addClass("fa-eye-slash");
                }
            });
        });
    </script>

    <script>
        window.onbeforeclose = function() {
            return "";
        }
    </script>

    <script>
        const isChangepwCB = document.getElementById('changepw');
        const pwInput = document.getElementById('password');
        const rePwInput = document.getElementById('password-confirm');
        isChangepwCB.addEventListener('change',function(){
            if(this.checked){
                pwInput.disabled = false;
                rePwInput.disabled = false;
            }else{
                pwInput.disabled = true;
                rePwInput.disabled = true;
            }
        });
    </script>
@endsection