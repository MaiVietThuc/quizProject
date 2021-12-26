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
    <!-- custom -->
    <link href="{{asset('/css/admin_style.css')}}" rel="stylesheet">

</head>

<body>

    <div class="container bg-white">
        <div class="header-title text-center m-3">
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
            <h3 class=" m-2 font-weight-bold text-primary ">{{$exam->title}}</h3> 
        </div>
        <hr class="my-2">
        <form action="{{URL::to('student/submitExam/'.$exam->id.'')}}" method="POST" id="form_exam">
            @csrf
            <input type="hidden" id="time_start" name="time_start" value="">
        <div class="row">
            <div class="col-lg-9 bg-white">
                <div class="wrap-scroll border-0 ">
                    {{-- a question --}}
                    @foreach ($exam->question as $ques)
                        <div class="wrap-answer mt-3 mb-5 rounded bg-light" id="quest_{{$ques->id}}">
                            <div class="question-title m-3 pt-4">
                                <h5 class="font-weight-bold">Câu {{$loop->index+1}}: {{$ques->question_title}}</h5>
                                @if ($ques->question_img != '')
                                <img class="text-center" src="{{asset($ques->question_img)}}" alt="" style="max-width:80%; max-height:700px;">
                                @endif
                            </div>
                            <div class="question-answer">
                                <ul class="list-group list-group-flush bg-light">
                                    <li class="list-group-item border-0 bg-light">
                                        <input type="radio" id="{{$ques->id}}-ans_1" class="{{$ques->id}}" name="question_{{$ques->id}}" onclick="getCheck(this);" value="ans_1"> 
                                        <label class="m-0 pl-2" for="{{$ques->id}}-ans_1">  {{$ques->ans_1}}</label> 
                                    </li>
                                    <li class="list-group-item border-0 bg-light">
                                        <input type="radio" id="{{$ques->id}}-ans_2" class="{{$ques->id}}" name="question_{{$ques->id}}" onclick="getCheck(this);" value="ans_2"> 
                                        <label class="m-0 pl-2" for="{{$ques->id}}-ans_2">  {{$ques->ans_2}}</label>
                                    </li>
                                    @if($ques->ans_3 != '')
                                    <li class="list-group-item border-0 bg-light">
                                        <input type="radio" id="{{$ques->id}}-ans_3" class="{{$ques->id}}" name="question_{{$ques->id}}" onclick="getCheck(this);" value="ans_3"> 
                                        <label class="m-0 pl-2" for="{{$ques->id}}-ans_3">  {{$ques->ans_3}}</label>
                                    </li>
                                    @endif
                                    @if($ques->ans_4 != '')
                                    <li class="list-group-item border-0 bg-light">
                                        <input type="radio" id="{{$ques->id}}-ans_4" class="{{$ques->id}}" name="question_{{$ques->id}}" onclick="getCheck(this);" value="ans_4">
                                        <label class="m-0 pl-2" for="{{$ques->id}}-ans_4">  {{$ques->ans_4}}</label>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        {{--  --}}
                    @endforeach
                </div>
                <h6 class="font-italic text-center b-buttom"><strong>Hết</strong></h6>
            </div>
            <div class="col-lg-3  mt-4">
                <div class="sticky-top pt-lg-4">
                    <div class="exam-inf mb-3 text-center">
                        <input class="text-center input-lg border-0" type="text" name="remain-time" id="remain-time"
                            @if (Session('error'))
                                value="{{$remainingTime}}"
                            @else
                                value="{{$exam->duration*60}}" 
                            @endif
                            size="5" readonly="true" style="font-size: 2rem; font-weight:bold;">
                        <h6 class="font-weight-bold">Hoàn thành: <strong class="ml-2" id="completed-question">0</strong><strong class="ml-2">/{{$exam->question->count()}}</strong> </h6>
                    </div>
                    <hr>
                    <p>Danh sách câu hỏi:</p>
                    <div class="question-link row row-cols-5 m-2 mt-3">
                        @foreach ($exam->question as $qu)
                            <div class="col p-1">
                                <a href="#quest_{{$qu->id}}" id="link-question-{{$qu->id}}" class="pagination-question text-decoration-none text-dark font-weight-bold rounded-circle">{{$loop->index+1}}</a>
                            </div>
                        @endforeach
                    </div>
                    <hr class="mt-3 mb-2">  
                    <div class="wrap text-center mt-5">
                        <button type="submit" class="bg-primary text-light rounded">Nộp bài</button>
                    </div>
                    
                </div>
            </div>
        </div>
        </form>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script>
        window.onload = function(){
            var today = new Date();
            var date = today.getFullYear()+'/'+(today.getMonth()+1)+'/'+today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date+' '+time;
            document.getElementById('time_start').value = dateTime;
        }
        window.onbeforeunload = function() {
            return "";
        }
    </script>
    <script>
        $("#bt-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#bt-alert").slideUp(500);
        });
    </script>
    <script>
            var countdown = setInterval(remainingTime, 1000);
            var displayRemainTime = document.getElementById('remain-time');
            var remainTime = displayRemainTime.value;         
            function remainingTime(){
                var minutes = Math.floor(remainTime/60);
                var seconds = Math.floor(remainTime-(minutes*60));
                displayRemainTime.value = minutes +" : "+seconds;
                remainTime = remainTime -1;
                if(remainTime == 600){
                    alert("Còn 10 phút!");
                }
                if(remainTime == 0){
                    clearInterval(countdown);
                    document.getElementById('form_exam').submit();
                }
            }
    </script>
    <script>
        function getCheck(e){
            let getId = e.id.split('-')[0];
            const thisId = document.getElementById('link-question-'+getId);
            thisId.classList.remove("text-dark");
            thisId.classList.add("bg-primary","text-white","complete-quest");
            //change completed question
            let completeQuest = document.getElementsByClassName('complete-quest').length;
            document.getElementById('completed-question').innerHTML =completeQuest;
        }
    </script>

</body>

</html>