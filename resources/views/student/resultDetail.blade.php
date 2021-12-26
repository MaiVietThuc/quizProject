@extends('student_layout')

@section('student_content')

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
            <h3 class=" m-2 text-primary mb-3">Kết quả kiểm tra <br><strong>{{$exam_info->title}}</strong></h3> 
            @if (Session('failed'))
                <h4 class=" m-2 text-danger mb-3">{{session('failed')}}</h4>
            @endif
        </div>

        @if(!Session('error') && !Session('failed'))
        <div class="exam-result text-center">
            <h5 class="mb-1">Điểm: <strong>{{$stStudentExam->mark}}/{{$exam_info->total_marks}}</strong></h5>
            <h5>Bắt đầu làm bài: {{$stStudentExam->time_start->format('H:i:s \N\g\à\y  d-m-Y')}}</h5>
            <h5>Nộp bài: {{$stStudentExam->time_end->format('H:i:s  \N\g\à\y  d-m-Y')}}</h5>
        </div>
        <hr class="my-2">
        
        <div class="row">
            <div id="exam-content" class="col-lg-9 bg-white">
                <div class="wrap-scroll border-0 ">
                    {{-- a question --}}
                    @foreach ($studentAnswer as $stques)
                        <div class="wrap-answer rounded bg-light" id="quest_{{$loop->index+1}}">
                            <div class="question-title ">
                                <h5>Câu {{$loop->index+1}}: <strong> {{$stques->question->question_title}}</strong></h5>
                                @if ($stques->question->question_img != '')
                                <img class="text-center" src="{{asset($stques->question->question_img)}}" alt="" style="max-width:80%; max-height:700px;">
                                @endif
                            </div>
                            <div class="question-answer">
                                <ul class="list-group list-group-flush bg-light">
                                    <li class="list-group-item border-0  
                                    @if ($stques->question->corr_ans == 'ans_1' && $stques->user_answer_option == 'ans_1')
                                        bg-success text-light
                                    @elseif($stques->question->corr_ans == 'ans_1' && is_null($stques->user_answer_option))
                                            bg-danger text-light
                                    @elseif($stques->question->corr_ans == 'ans_1' && $stques->user_answer_option != 'ans_1')
                                        bg-success text-light
                                    @elseif($stques->question->corr_ans != 'ans_1' && $stques->user_answer_option == 'ans_1')
                                        bg-danger text-light
                                    @endif"> 
                                        <label class="m-0 pl-2" for="rad-{{$loop->index+1}}-ans_1">  {{$stques->question->ans_1}}</label> 
                                    </li>
                                    <li class="list-group-item border-0 
                                    @if ($stques->question->corr_ans == 'ans_2' && $stques->user_answer_option == 'ans_2')
                                        bg-success text-light
                                    @elseif($stques->question->corr_ans == 'ans_2' && is_null($stques->user_answer_option))
                                            bg-danger text-light
                                    @elseif($stques->question->corr_ans == 'ans_2' && $stques->user_answer_option != 'ans_2')
                                        bg-success text-light
                                    @elseif($stques->question->corr_ans != 'ans_2' && $stques->user_answer_option == 'ans_2')
                                        bg-danger text-light
                                    @endif"> 
                                        <label class="m-0 pl-2" for="rad-{{$loop->index+1}}-ans_2">  {{$stques->question->ans_2}}</label>
                                    </li>
                                    <li class="list-group-item border-0 
                                    @if ($stques->question->corr_ans == 'ans_3' && $stques->user_answer_option == 'ans_3')
                                        bg-success text-light
                                    @elseif($stques->question->corr_ans == 'ans_3' && is_null($stques->user_answer_option))
                                            bg-danger text-light
                                    @elseif($stques->question->corr_ans == 'ans_3' && $stques->user_answer_option != 'ans_3')
                                        bg-success text-light
                                    @elseif($stques->question->corr_ans != 'ans_3' && $stques->user_answer_option == 'ans_3')
                                        bg-danger text-light
                                    @endif"> 
                                        <label class="m-0 pl-2" for="rad-{{$loop->index+1}}-ans_3">  {{$stques->question->ans_3}}</label>
                                    </li>
                                    <li class="list-group-item border-0 
                                    @if ($stques->question->corr_ans == 'ans_4' && $stques->user_answer_option == 'ans_4')
                                        bg-success text-light
                                    @elseif($stques->question->corr_ans == 'ans_4' && is_null($stques->user_answer_option))
                                            bg-danger text-light
                                    @elseif($stques->question->corr_ans == 'ans_4' && $stques->user_answer_option != 'ans_4')
                                        bg-success text-light
                                    @elseif($stques->question->corr_ans != 'ans_4' && $stques->user_answer_option == 'ans_4')
                                        bg-danger text-light
                                    @endif"> 
                                        <label class="m-0 pl-2" for="rad-{{$loop->index+1}}-ans_4">  {{$stques->question->ans_4}}</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{--  --}}
                    @endforeach
                </div>
                <h6 class="font-italic text-center b-buttom">Hết</h6>
            </div>
            <div class="col-lg-3  mt-4">
                <div class="sticky-top pt-lg-4">
                    <div class="exam-inf mb-3 text-center">
                        {{-- <h6 class="font-weight-bold">Kết quả: <strong class="ml-2">0/9.5</strong> </h6> --}}
                    </div>
                    <hr>
                    <p>Danh sách câu hỏi:</p>
                    <div class="question-link row row-cols-5 m-2 mt-3">
                        @foreach ($studentAnswer as $stques)
                            <div class="col p-1">
                                @if ($stques->user_answer_option == $stques->question->corr_ans)
                                    <a href="#quest_{{$loop->index+1}}" id="link-question" class="pagination-question text-decoration-none font-weight-bold rounded-circle text-white bg-success">{{$loop->index+1}}</a>                                  
                                @else
                                    <a href="#quest_{{$loop->index+1}}" id="link-question" class="pagination-question text-decoration-none font-weight-bold rounded-circle text-white bg-danger">{{$loop->index+1}}</a>  
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr class="mt-3 mb-2"> 
                    <div class="wrap text-center mt-5">
                        <input type="button" onclick="printDiv('exam-content')" value="In đề" class="bg-primary text-light rounded"/>
                        <a href="{{URL::to('student')}}"><button class="bg-primary text-light rounded">Về trang chủ</button></a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection
@section('script')
    <script>
        function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    </script>
@endsection