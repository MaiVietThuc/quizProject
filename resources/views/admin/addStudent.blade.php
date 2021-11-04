@extends('admin_layout')

@section('admin_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('/admin/student')}}">Quản lý sinh viên</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm sinh viên</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 pl-3">Thêm Sinh viên</h1>
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
    <form class="" action="{{URL::to('/admin/postAddStudent')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card-box shadow col-10 ml-5  pt-3 pb-3">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Bắt buộc</h5>
                    
                    <div class="form-group mb-3">
                        <label for="product-name">MSSV:<span class="text-danger">*</span></label>
                        <input type="text" id="mssv" name="mssv" class="form-control" placeholder="Mã số sinh viên">
                    </div>

                    <div class="form-group mb-3">
                        <label for="product-name">Tên sinh viên:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tên sinh viên">
                    </div>

                    <div class="form-group mb-3">
                            <label for="product-category">Chuyên ngành:<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="majors" id="studentMajors">
                                @foreach ($majors as $mj)
                                    <option value="{{$mj->id}}">{{$mj->name}}</option>
                                @endforeach                            
                            </select>
                    </div>

                    <div class="form-group mb-3">
                            <label for="product-category">Giới tính:<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="gender" id="gender">
                                <option value="0">Nam</option>
                                <option value="1">Nữ</option>
                            </select>
                    </div>             

                    <div class="form-group mb-3">
                        <label for="product-reference">Mật khẩu:<span class="text-danger">*</span></label>
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
                </div> <!-- end card-box -->
            </div> <!-- end col -->

            <div class="col-lg-6">

                <div class="card-box shadow col-10  mr-5 pt-3 pb-3">
                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Thông tin tùy chọn</h5>   
                    
                    <div class="form-group mb-3">
                        <label for="product-summary">Email:</label>
                        <input class="form-control" name="email"  rows="2" placeholder="email" autocomplete="false">
                    </div>

                    <div class="form-group mb-3">
                        <div class="fallback">
                            <label for="image1">Ảnh đại diện<span class="text-danger"> : </span></label><br>
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
                        <a onclick="cancelConfirm()" href="{{URL::to('/admin/student')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
                        <button type="submit" class="btn btn-primary">Thêm</button>
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
        window.onbeforeunload = function() {
            return "";
        }
    </script>
@endsection