@extends('teacher_layout')

@section('teacher_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
          <li class="breadcrumb-item active"><a href="#"><i class="fa fa-home" aria-hidden="true"></i> Tổng quan</a></li>
        </ol>
    </nav>

    <!-- main content -->
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
    <form class="" action="{{URL::to('/teacher/postManagerAccount')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="row card-box shadow">
            <div class="col-lg-6">
                <h6 class="text-uppercase bg-light p-2 mt-0 mb-3">Thông tin cá nhân:</h6>
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
                            <input  name="avatar" type="file" rows="3" id="avatar"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6">
                <div class="mr-5 pt-3 pb-3">
                    <h5>Đổi mật khẩu</h5>

                    <div class="form-group mb-3">
                        <div class="radio form-check mr-4 pl-0 mt-4">
                            <label for="changepw">
                                <input type="checkbox" id="changepw" value="1" name="changepw"> 
                                Đổi mật khẩu
                            </label>
                        </div>
                        <label for="product-reference">Mật khẩu cũ:</label>
                        <div class="input-group input-group-merge" id="form-old-password">                                            
                            <input type="password" name="old_password" id="oldpassword" class="form-control" placeholder="Mật khẩu cũ" autocomplete="false" disabled>                                  
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

                    <div class="text-center mb-3" >
                        <a onclick="cancelConfirm()" href="{{URL::to('/teacher')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    @section('script')
    <script>
        $(document).ready(function() {
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
                }else if($('#form-confirm-pw input').attr("type") == "password"){
                    $('#form-confirm-pw input').attr('type', 'text');
                    $('#form-confirm-pw i').removeClass( "fa-eye" );
                    $('#form-confirm-pw i').addClass("fa-eye-slash");
                }
            });
        });
    </script>
    <script>
        const isChangepwCB = document.getElementById('changepw');
        const oldPwInput = document.getElementById('oldpassword');
        const pwInput = document.getElementById('password');
        const rePwInput = document.getElementById('password-confirm');
        isChangepwCB.addEventListener('change',function(){
            if(this.checked){
                pwInput.disabled = false;
                rePwInput.disabled = false;
                oldPwInput.disabled = false;
            }else{
                pwInput.disabled = true;
                rePwInput.disabled = true;
                oldPwInput.disabled = true;
            }
        });
    </script>
    @endsection
@endsection