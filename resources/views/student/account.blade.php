@extends('student_layout')

@section('student_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="{{URL::to('/student')}}"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa tài khoản</li>
        </ol>
    </nav>

    <!-- Page Heading -->
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
    <form class="" action="{{URL::to('/student/postManagerAccount')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row card-box shadow">
            <div class="col-lg-6 ">
                <div class=" col-10 ml-5  pt-3 pb-3">
                    <div class="form-group mb-3">
                        <label for="product-name">MSSV:</label>
                        <input type="text" id="mssv" name="mssv" value="{{$you->student_code}}" class="form-control" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label for="product-name">Tên sinh viên:</label>
                        <input type="text" id="name" name="name" value="{{$you->name}}" class="form-control"  disabled>
                    </div>

                    <div class="form-group mb-3">
                            <label for="product-category">Chuyên ngành:</label>
                            <select class="form-control select2" name="majors" id="studentMajors" disabled>
                                <option value="{{$you->majors->name}}" selected>{{$you->majors->name}}</option>                          
                            </select>
                    </div>

                    <div class="form-group mb-3">
                            <label for="product-category">Giới tính:</label>
                            <select class="form-control select2" name="gender" id="gender" disabled>
                                @if ($you->gender == 0)
                                    <option value="0" selected>Nam</option>
                                    <option value="1">Nữ</option>
                                @else
                                    <option value="0" >Nam</option>
                                    <option value="1"selected>Nữ</option>
                                @endif
                            </select>
                    </div>             

                    <div class="form-group mb-3">
                        <label for="product-summary">Email:</label>
                        <input class="form-control" name="email"  rows="2" value="{{$you->email}}" autocomplete="false" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <div class="fallback">
                            <label for="image1">Ảnh đại diện<span class="text-danger"> : </span></label><br>
                            @if (!empty($you->avatar))
                                <img src="{{asset($you->avatar)}}" alt="" width="35px" height="35px">
                            @else
                                <img src="{{asset('img/user.png')}}" alt="" width="35px" height="35px">
                            @endif
                            <input  name="avatar" type="file" rows="3" id="avatar"/>
                        </div>
                    </div>
                    
                </div> <!-- end card-box -->
            </div> <!-- end col -->

            <div class="col-lg-6">
                <div class=" col-10  mr-5 pt-3 pb-3">
                    <h5>Đổi mật khẩu</h5>

                    <div class="form-group mb-3">
                        <label for="product-reference">Mật khẩu cũ:</label>
                        <div class="input-group input-group-merge" id="form-old-password">                                            
                            <input type="password" name="old_password" class="form-control" placeholder="Mật khẩu cũ" autocomplete="false">                                  
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href=""><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="product-reference">Đổi mật khẩu:</label>
                        <div class="input-group input-group-merge" id="form-password">                                            
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" autocomplete="false">                                  
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
                            <input type="password"  name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" autocomplete="false">
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href=""><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-3" >
                        <a onclick="cancelConfirm()" href="{{URL::to('/student')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
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

            $("#form-old-password a").on('click', function(event) {
                event.preventDefault();
                if($('#form-old-password input').attr("type") == "text"){
                    $('#form-old-password input').attr('type', 'password');
                    $('#form-old-password i').addClass( "fa-eye" );
                    $('#form-old-password i').removeClass( "fa-eye-slash" );
                }else if($('#form-old-password input').attr("type") == "password"){
                    $('#form-old-password input').attr('type', 'text');
                    $('#form-old-password i').removeClass( "fa-eye" );
                    $('#form-old-password i').addClass("fa-eye-slash");
                }
            });
        });
    </script>
@endsection