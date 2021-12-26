<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    
    <!-- bootstrap 4.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- font--awesome -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <!-- mainform -->
    <form class="" action="{{URL::to('/pNewPassword')}}" method="post" autocomplete="off">
        @csrf
        <input type="hidden" name="id" value="{{$id}}">
        <input type="hidden" name="token" value="{{$token}}">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{session('error')}}!      
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{session('success')}}!
                    </div>
                @endif
                <div class="card-box shadow col-10 ml-5  mt-5">
                    <h3 class="h3 mt-4 mb-4 text-gray-800 pl-3">Nhập mật khẩu mới</h3>

                    <div class="form-group mb-3">
                        <label for="product-reference">Mật khẩu mới:<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge" id="form-password">                                            
                            <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" autocomplete="false">                                  
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href="#"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                        <label for="product-reference">Xác nhật mật khẩu:<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge" id="form-confirm-pw">
                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" autocomplete="false">
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <a href="#"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-5" >
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>

                </div> <!-- end card-box -->
            </div> <!-- end col -->
            <div class="col-lg-3"></div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
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
                }else if($('#form-confirm-pw input').attr("type") == "password"){
                    $('#form-confirm-pw input').attr('type', 'text');
                    $('#form-confirm-pw i').removeClass( "fa-eye" );
                    $('#form-confirm-pw i').addClass("fa-eye-slash");
                }
            });
        });
    </script>
</body>
</html>
