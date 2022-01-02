@extends('admin_layout')
@section('admin_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="{{URL::to('admin/')}}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa tài khoản</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 pl-3">Sửa tài khoản</h1>
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

    <form class="" action="{{URL::to('/admin/postAccountSetting')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card-box shadow col-10 ml-5  pt-3 pb-3">

                    <div class="form-group mb-3">
                        <label for="product-name">Tên:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tên" value="{{$currAdmin->name}}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="product-name">Email<span class="text-danger">*</span></label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="{{$currAdmin->email}}">
                    </div>

                    <div class="form-group mb-3">
                        <div class="fallback">
                            <label for="image1">Ảnh đại diện<span class="text-danger"> : </span></label><br>
                            @if ($currAdmin->avatar!='')
                                <img src="{{asset($currAdmin->avatar)}}" alt="" width="35px" height="35px">
                            @else
                                <img src="{{asset('img/user.png')}}" alt="" width="35px" height="35px">
                            @endif
                            <input  name="avatar" type="file" rows="3" id="avatar"/>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <div class="radio form-check mr-4 pl-0 mt-4">
                            <label for="changepw">
                                <input type="checkbox" id="changepw" value="1" name="changepw"> 
                                Đổi mật khẩu
                            </label>
                        </div>
                        <label for="product-reference">Mật khẩu cũ:<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge" id="form-old-password">                                            
                            <input type="password" id="oldpassword" name="old_password" class="form-control" placeholder="Mật khẩu cũ" autocomplete="false" disabled>                                  
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href="javascript:void(0)"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="product-reference">Mật khẩu mới:<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge" id="form-password">                                            
                            <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" autocomplete="false" disabled>                                  
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href="#"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                        <label for="product-reference">Xác nhật mật khẩu:<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge" id="form-confirm-pw">
                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" autocomplete="false" disabled>
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href="#"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-3" >
                        <a onclick="cancelConfirm()" href=""><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>

                </div> <!-- end card-box -->
            </div> <!-- end col -->
            <div class="col-lg-3"></div>
        </div>
    </form>
@endsection

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