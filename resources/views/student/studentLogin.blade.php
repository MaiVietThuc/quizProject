<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student-login</title>
    
    <!-- bootstrap 4.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- font--awesome -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <div class="container"> 
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">
                    <div class="card-body p-4">
                        <a href="{{asset('')}}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                        <div class="text-center w-75 m-auto">                                
                            <h5 class="text-muted mb-4 mt-3">Sinh viên đăng nhập</h5>
                            @if (session('error'))
                                <div class="alert alert-dannger alert-dismissible">
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
                        </div>

                        <form action="{{URL::to('/postStudentLogin')}}" method="POST">
                            @csrf                         
                            <div class="form-group mb-3">
                                <label for="emailaddress">Tên tài khoản</label>
                                <input class="form-control" type="email"  name="email" id="account"  required="" placeholder="Nhập tên tài khoản của bạn">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Mật khẩu</label>
                                <div class="input-group input-group-merge" id="form-pw">
                                    <input type="password" id="password"  name="password" class="form-control"  placeholder="Nhập mật khẩu của bạn">
                                    <div class="input-group-append"  data-password="false">
                                        <div class="input-group-text">
                                            <a href=""><i class="fas fa-eye"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="custom-control  custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"  id="checkbox-signin" checked>
                                    <label class="custom-control-label"  for="checkbox-signin">Lưu mật khẩu</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Đăng nhập </button>
                            </div>

                        </form>
                        <p class="mt-3"> <a href="{{URL::to('/studentForgetPassword')}}" class="text-black-50">Quên mật khẩu ?</a></p>
                    </div> 
                </div>                   

                <div class="row mt-3">
                    <div class="col-12 text-center">
                    </div> 
                </div>
            </div>
        </div>
    </div>


    {{-- <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
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
        });
    </script>
</body>
</html>