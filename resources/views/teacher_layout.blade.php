<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('/tracnghiemtructuyen-favicon.png')}}" type="image/x-icon" />
    <title>Trắc nghiệm trực tuyến || Teacher side</title>

    <!-- bootstrap 4.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <!-- font--awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- custom -->
    <link href="{{asset('/css/admin_style.css')}}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary-tc sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{URL::to('')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <div class="sidebar-brand-text mx-3">TRẮC NGHIỆM TRỰC TUYẾN.xyz</div>
            </a>

            <hr class="sidebar-divider my-0">

            
            <!-- Nav Item - Pages  Menu -->

            <li class="nav-item @if (Request::path() == 'teacher/') active  @endif">
                <a class="nav-link" href="{{URL::to('/teacher/')}}">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <span>Tổng quan</span></a>
            </li>


            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Lớp
            </div>

            <li class="nav-item @if (Request::path() == 'teacher/class') active  @endif">
                <a class="nav-link" href="{{URL::to('/teacher/class/')}}">
                    <i class="fas fa-users"></i>
                    <span>Lớp phụ trách</span></a>
            </li>

            <li class="nav-item @if (Request::path() == 'teacher/historyClass') active  @endif">
                <a class="nav-link" href="{{URL::to('/teacher/historyClass/')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Lịch sử phụ trách</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="sidebar-heading">
                Bài kiểm tra
            </div>

            <li class="nav-item @if (Request::path() == 'teacher/exam') active  @endif">
                <a class="nav-link" href="{{URL::to('/teacher/exam/')}}">
                    <i class="fas fa-users"></i>
                    <span>Quản lý bài kiểm tra</span></a>
            </li>

            <li class="nav-item @if (Request::path() == 'teacher/exam/history') active  @endif">
                <a class="nav-link" href="{{URL::to('/teacher/exam/history')}}">
                    <i class="fas fa-users"></i>
                    <span>Lịch sử & kết quả kiểm tra</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item ">
                <a class="nav-link" href="{{URL::to('')}}">
                    <i class="fas fa-comment-dots"></i>
                    <span>Phản hổi sinh viên</span></a>
            </li>
           
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li> --}}
            <!-- Divider -->
           

            <!-- Sidebar Toggler (Sidebar) -->
            {{-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> --}}

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <div class="ml-5 d-sm-inline-block form-inline">
                        <h1>Trang dành cho giảng viên </h1>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Infor -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-3 d-none d-lg-inline font-weight-bold text-gray-600 ">{{Auth::guard('teacher')->user()->name}}</span>
                                <img class="img-profile rounded-circle" src="@if (Auth::guard('teacher')->user()->avatar != '') {{asset(Auth::guard('teacher')->user()->avatar)}} @else {{asset('/img/user.png')}} @endif">
                            </a>
                            <!-- User Inf -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cài đặt tài khoản
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    
                    @yield('teacher_content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Website kiểm tra trắc nghiệm trực tuyến phân hiệu đại học Thủy Lợi</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog-cus mt-5" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn muốn đăng xuất?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="{{URL::to('/teacherLogout')}}">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- datatable -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    
    @yield('script')

    <script>
        !function (l) {
            "use strict";
            l("#sidebarToggle, #sidebarToggleTop").on("click", function (e) {
                l("body").toggleClass("sidebar-toggled"), l(".sidebar").toggleClass("toggled"), l(".sidebar").hasClass("toggled") && l(".sidebar .collapse").collapse("hide")
            }), l(window).resize(function () {
                l(window).width() < 768 && l(".sidebar .collapse").collapse("hide"), l(window).width() < 480 && !l(".sidebar").hasClass("toggled") && (l("body").addClass("sidebar-toggled"), l(".sidebar").addClass("toggled"), l(".sidebar .collapse").collapse("hide"))
            }), l("body.fixed-nav .sidebar").on("mousewheel DOMMouseScroll wheel", function (e) {
                var o;
                768 < l(window).width() && (o = (o = e.originalEvent).wheelDelta || -o.detail, this.scrollTop += 30 * (o < 0 ? 1 : -1), e.preventDefault())
            }), l(document).on("scroll", function () {
                100 < l(this).scrollTop() ? l(".scroll-to-top").fadeIn() : l(".scroll-to-top").fadeOut()
            }), l(document).on("click", "a.scroll-to-top", function (e) {
                var o = l(this);
                l("html, body").stop().animate({
                    scrollTop: l(o.attr("href")).offset().top
                }, 1e3, "easeInOutExpo"), e.preventDefault()
            })
        }(jQuery);

        $("#bt-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#bt-alert").slideUp(500);
        });
    </script>
    <script>
        function deleteConfirm(){
            if (confirm('Dữ liệu đã xóa không thể phục hồi, Bạn có chắc muốn xóa?'))
            {
                return true;
            }else{
                event.stopPropagation();
                event.preventDefault();
            };
        }

        function cancelConfirm(){
            if (confirm('Dữ liệu chưa được lưu, Bạn có chắc muốn thoát?'))
            {
                return true;
            }else{
                event.stopPropagation();
                event.preventDefault();
            };
        }
    </script>
</body>

</html>