@extends('admin_layout')

@section('admin_content')

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
            <h2 class="m-2 text-primary mb-3"><strong>{{$exam->title}}</strong></h2>
        </div>
        <hr class="my-2">
        
        <div class="row">
            <div id="exam-content" class="col-lg-9 bg-white">
                <div class="wrap-scroll border-0 ">
                    {{-- a question --}}
                    @foreach ($exam->question as $exm)
                        <div class="wrap-answer rounded bg-light" id="quest_{{$loop->index+1}}">
                            <div class="question-title ">
                                <h5>Câu {{$loop->index+1}}: <strong> {{$exm->question_title}}</strong></h5>
                                @if ($exm->question_img != '')
                                <img class="text-center" src="{{asset($exm->question_img)}}" alt="" style="max-width:80%; max-height:700px;">
                                @endif
                            </div>
                            <div class="question-answer">
                                <ul class="list-group list-group-flush bg-light">
                                    <li class="list-group-item border-0  
                                    @if ($exm->corr_ans == 'ans_1')
                                        bg-success text-light
                                    @endif"> 
                                        <label class="m-0 pl-2" for="rad-{{$loop->index+1}}-ans_1">  {{$exm->ans_1}}</label> 
                                    </li>
                                    <li class="list-group-item border-0 
                                    @if ($exm->corr_ans == 'ans_2')
                                        bg-success text-light
                                    @endif"> 
                                        <label class="m-0 pl-2" for="rad-{{$loop->index+1}}-ans_2">  {{$exm->ans_2}}</label>
                                    </li>
                                    <li class="list-group-item border-0 
                                    @if ($exm->corr_ans == 'ans_3')
                                        bg-success text-light
                                    @endif"> 
                                        <label class="m-0 pl-2" for="rad-{{$loop->index+1}}-ans_3">  {{$exm->ans_3}}</label>
                                    </li>
                                    <li class="list-group-item border-0 
                                    @if ($exm->corr_ans == 'ans_4')
                                        bg-success text-light
                                    @endif"> 
                                        <label class="m-0 pl-2" for="rad-{{$loop->index+1}}-ans_4">  {{$exm->ans_4}}</label>
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
                        @foreach ($exam->question as $ques)
                            <div class="col p-1">
                                    <a href="#quest_{{$loop->index+1}}" id="link-question" class="pagination-question text-decoration-none font-weight-bold rounded-circle text-success">{{$loop->index+1}}</a>
                            </div>
                        @endforeach
                    </div>
                    <hr class="mt-3 mb-2"> 
                    <div class="wrap text-center mt-5">
                        <input type="button" onclick="printDiv('exam-content')" value="In đề" class="bg-primary text-light rounded"/>
                    </div>
                </div>
            </div>
        </div>
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