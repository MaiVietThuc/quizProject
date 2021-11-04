@extends('admin_layout')

@section('admin_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/')}}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{URL::to('/admin/student')}}">Quản lý sinh viên</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa tài khoản sinh viên</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 pl-3">Sửa tài khoản sinh viên</h1>

    <!-- mainform -->
    <form action="{{URL::to('admin/postEditStudent/'.$student->id.'')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card-box shadow col-10 ml-5  pt-3 pb-3">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Bắt buộc</h5>
                    
                    <div class="form-group mb-3">
                        <label for="product-name">MSSV:<span class="text-danger">*</span></label>
                        <input type="text" id="studentNumber" name="studentNumber" class="form-control" placeholder="Mã số sinh viên" value="{{$student->student_code}}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="product-name">Tên sinh viên:<span class="text-danger">*</span></label>
                        <input type="text" id="studentName" name="studentName" class="form-control" placeholder="Tên sinh viên" value="{{$student->name}}">
                    </div>

                    <div class="form-group mb-3">
                            <label for="product-category">Chuyên ngành:<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="studentMajors" id="studentMajors">
                                @foreach ($majors as $mj)
                                    @if($student->majors->name ==$mj->name)
                                        <option selected value="{{$mj->id}}">{{$mj->name}}</option>
                                    @else
                                        <option value="{{$mj->id}}">{{$mj->name}}</option>
                                    @endif
                                @endforeach       
                            </select>
                    </div>

                    <div class="form-group mb-3">
                            <label for="product-category">Giới tính:<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="gender" id="gender">
                                @if ($student->gender ==0)
                                    <option selected value="0">Nam</option>
                                    <option value="1">Nữ</option>
                                @else
                                    <option selected value="1">Nữ</option>
                                    <option value="0">Nam</option>
                                @endif                             
                            </select>
                    </div>             

                    <div class="form-group mb-3 mt-3">
                        <div class="radio form-check mr-4 pl-0 mt-4">
                            <label for="changepw">
                                <input type="checkbox" id="changepw" value="1" name="changepw"> 
                                Đổi mật khẩu
                            </label>
                        </div>                       
                        <label for="product-reference">Mật khẩu:<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge" id="form-pw">                                            
                            <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" autocomplete="false" disabled>                                  
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
                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" disabled>
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
                        <label for="product-summary">Email:</label>
                        <input class="form-control" name="email"  rows="2" placeholder="email" autocomplete="false" value="{{$student->email}}">
                    </div>

                    <div class="form-group mb-3">
                        <div class="fallback">
                            <label for="image1">Ảnh đại diện<span class="text-danger"> : </span></label><br>
                            @if (!empty($student->avatar))
                                <img src="{{asset($student->avatar)}}" alt="" width="35px" height="35px">
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
                                @if($student->status==1)
                                <input type="radio" id="inlineRadio1" value="1" name="status" checked> 
                                @else
                                <input type="radio" id="inlineRadio1" value="1" name="status" > 
                                @endif
                                Hiển thị:
                            </label>
                        </div>
                        <div class="radio form-check-inline">
                            <label for="inlineRadio2">
                                @if($student->status==0)
                                <input type="radio" id="inlineRadio2" value="0" name="status" checked>
                                @else
                                <input type="radio" id="inlineRadio2" value="0" name="status" >
                                @endif
                                 Ẩn 
                            </label>
                        </div>
                
                    </div>

                    <div class="text-center mb-3" >
                        <a onclick="cancelConfirm()" href="{{URL::to('/admin/student')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
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
            $("#form-pw a").on('click', function(event) {
                event.preventDefault();
                if($('#form-pw input').attr("type") == "text"){
                    $('#form-pw input').attr('type', 'password');
                    $('#form-pw i').addClass( "fa-eye" );
                    $('#form-pw i').removeClass( "fa-eye-slash" );
                }else if($('#form-pw input').attr("type") == "password"){
                    $('#form-pw input').attr('type', 'text');
                    $('#form-pw i').removeClass( "fa-eye" );
                    $('#form-pw i').addClass("fa-eye-slash");
                }
            });
            
            $("#form-confirm-pw a").on('click', function(event) {
                event.preventDefault();
                if($('#form-confirm-pw input').attr("type") == "text"){
                    $('#form-confirm-pw input').attr('type', 'password');
                    $('#form-confirm-pw i').addClass( "fa-eye" );
                    $('#form-confirm-pw i').removeClass( "fa-eye-slash" );
                }else if($('#form-pw input').attr("type") == "password"){
                    $('#form-confirm-pw input').attr('type', 'text');
                    $('#form-confirm-pw i').removeClass( "fa-eye" );
                    $('#form-confirm-pw i').addClass("fa-eye-slash");
                }
            });
        });
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