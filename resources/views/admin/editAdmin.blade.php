@extends('admin_layout')

@section('admin_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('/admin/teacher')}}">Quản lý admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sửa admin</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 pl-3">Sửa admin</h1>
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
    <form class="" action="{{URL::to('/admin/postEditAdmin/'.$admin->id.'')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card-box shadow col-10 ml-5  pt-3 pb-3">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Bắt buộc</h5>

                    <div class="form-group mb-3">
                        <label for="product-name">Tên admin:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tên admin" value="{{$admin->name}}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="product-summary">Email:<span class="text-danger">*</span></label>
                        <input class="form-control" name="email"  rows="2" placeholder="email" autocomplete="false" value="{{$admin->email}}">
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
                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" autocomplete="false" disabled>
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
                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2"></h5>                   

                    
                    <div class="form-group mb-4">
                        <p class="mb-3 border-bottom">Quyền admin:</p>                  
                            @foreach ($ad_role as $rol)  
                                @if ($rol->id == $admin->role_id)
                                <div class="radio form-check-inline mr-5" title="{{$rol->inf}}">                       
                                    <label for="role_{{$rol->id}}">{{$rol->role_name}}
                                        <input type="radio" id="role_{{$rol->id}}" name="role" value="{{$rol->id}}" checked>
                                    </label>
                                </div>
                                @else
                                <div class="radio form-check-inline mr-5" title="{{$rol->inf}}">                       
                                    <label for="role_{{$rol->id}}">{{$rol->role_name}}
                                        <input type="radio" id="role_{{$rol->id}}" name="role" value="{{$rol->id}}">
                                    </label>
                                </div>
                                @endif
                            @endforeach
                    </div>

                    <div class="form-group mb-4">
                        <div class="fallback">
                            <label for="image1">Ảnh đại diện<span class="text-danger"> : </span></label><br>
                            @if (!empty($admin->avatar))
                                <img src="{{asset($admin->avatar)}}" alt="" width="35px" height="35px">
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
                        <a onclick="cancelConfirm()" href="{{URL::to('/admin/adminAccount')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
                        <button type="submit" class="btn btn-primary">Sửa</button>
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