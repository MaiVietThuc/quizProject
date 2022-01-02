<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('/tracnghiemtructuyen-favicon.png')}}" type="image/x-icon" />
    <title>Trắc nghiệm trực tuyến || Admin side</title>

    <!-- bootstrap 4.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- font--awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- custom -->
    <link href="{{asset('/css/admin_style.css')}}" rel="stylesheet">

</head>

<body>
    <div class="home-wrap">
        <div class="container justify-content-lg-center align-items-center bg-transparent">
            <div class="jumbotron bg-transparent">
                <div class="d-flex bg-transparent  p-3 rounded">
                    <a href="#" class="brand d-inline mr-3">
                        <img src="{{asset('/img/tlu.png')}}" height="70px" alt="">
                    </a>
                    <h2 class="text-center font-weigh-bold">Giải pháp kiểm tra trắc nghiệm trực tuyến tại Phân Hiệu Đại Học Thủy Lợi</h2>
                </div>
                <hr>
                <h4 class="font-italic">Bạn là: </h4>
                <div class="d-flex flex-column text-center mt-5 bg-transparent">
                    <div class="m-3 bg-transparent" >
                        <a href="{{URL::to('/adminlogin')}}" class="bt-login bg-info btn-lg text-light d-inline-block text-decoration-none">Quản trị viên</a>
                    </div>
                    <div class="m-3 bg-transparent" >
                        <a href="{{URL::to('/teacherLogin')}}" class="bt-login bg-info btn-lg text-light d-inline-block text-decoration-none">Giảng viên</a>
                    </div>
                    <div class="m-3 bg-transparent" >
                        <a href="{{URL::to('/studentLogin')}}" class="bt-login bg-info btn-lg text-light d-inline-block text-decoration-none">Sinh viên</a>
                    </div>
                </div>
            </div>
            
        </div>
        <footer class="sticky-footer fixed-bottom bg-transparent">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Website kiểm tra trắc nghiệm trực tuyến phân hiệu đại học Thủy Lợi</span>
                </div>
            </div>
        </footer>
    </div>
    <!-- Footer -->
    <!-- The Modal -->
    <div class="modal fade" id="login-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card bg-pattern">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">                               
                            <h5 class="text mb-4">ĐĂNG NHẬP</h5>
                            @if (session('error'))
                                <div class="alert alert-dannger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{session('error')}}!
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
                        <p class="mt-3"> <a href="#" class="text-black-50">Quên mật khẩu ?</a></p>
                        <p class="mt-3"> <a href="{{URL::to('/teacherLogin')}}" class="font-weight-bold text-black-50">Bạn là giảng viên?</a></p>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
    
    <!-- End of Footer -->

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

</html>