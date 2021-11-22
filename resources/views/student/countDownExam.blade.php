<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('/tracnghiemtructuyen-favicon.png')}}" type="image/x-icon" />
    <title>Trắc nghiệm trực tuyến || Student side</title>

    <!-- bootstrap 4.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <!-- font--awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- custom -->
    <link href="{{asset('/css/admin_style.css')}}" rel="stylesheet">

</head>

<body>
    <input type="hidden" name="time-countDown" id="time-countDown" value="{{$timeCoutDown}}">
    <div class="home-wrap">
        <div class="container justify-content-lg-center align-items-center height-100vh">
            <div class="jumbotron bg-transparent height-100vh ">
                <h1 class="text-center font-weigh-bold">{{$exam->title}}</h1>
                <h6 class="text-center font-weigh-bold">Bắt đầu sau:</h6>
                <div class="row mt-5">
                    <div class="col-3 bg-transparent text-center" >
                        <div class="card-body">
                          <h1 class="card-title display-1" id="days"></h1>
                        </div>
                    </div>
                    <div class="col-3 bg-transparent text-center" >
                        <div class="card-body">
                          <h1 class="card-title display-1" id="hours"></h1>
                        </div>
                    </div>
                    <div class="col-3 bg-transparent text-center" >
                        <div class="card-body">
                          <h1 class="card-title display-1" id="minutes"></h1>
                        </div>
                    </div>
                    <div class="col-3 bg-transparent text-center" >
                        <div class="card-body">
                          <h1 class="card-title display-1" id="seconds"></h1>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="pr-3 pl-3 pt-2 pb-2 border-0 rounded bg-secondary"><a class="text-decoration-none text-light" href="{{URL::to('student/exam/')}}">Trở về</a></button>
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





    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    

    <script>
            var countdownTimer = setInterval(countdown, 1000);

        
            var seconds = document.getElementById('time-countDown').value;
            const day =  document.getElementById('days');
            const hour = document.getElementById('hours');
            const minute = document.getElementById('minutes');
            const second = document.getElementById('seconds');

            var time = seconds;
            function countdown() {
                
                var d = Math.floor(time / (3600*24));
                var h = Math.floor(time % (3600*24) / 3600);
                var m = Math.floor(time % 3600 / 60);
                var s = Math.floor(time % 60);

                var dDisplay = d > 0 ? d + (d == 1 ? " ngày " : " ngày ") : "0 ngày";
                var hDisplay = h > 0 ? h + (h == 1 ? " giờ " : " giờ ") : "0 giờ";
                var mDisplay = m > 0 ? m + (m == 1 ? " phút " : " phút ") : "0 phút";
                var sDisplay = s > 0 ? s + (s == 1 ? " giây" : " giây") : "0 giây";
                // var cc = dDisplay + hDisplay + mDisplay + sDisplay;
                day.innerHTML = dDisplay;
                hour.innerHTML = hDisplay;
                minute.innerHTML = mDisplay;
                second.innerHTML = sDisplay;
                time = time - 1;
            };
        
    </script>
    
</body>

</html>