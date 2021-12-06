@extends('teacher_layout')

@section('teacher_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('/teacher/exam')}}">Quản lý bài kiểm tra</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$question->exam->title}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
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
    
    {{-- modal edit question & answer --}}
    <div class="row">
        <div class="card-shadow shadow mx-auto col-6" role="document">

            <form class="" action="{{URL::to('teacher/exam/postEditQuestion/'.$question->id.'')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Sửa câu hỏi:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="question"> <strong>Câu hỏi:</strong> <span class="text-danger">*</span></label>
                        <input type="text" id="question" name="question" class="form-control" placeholder="Câu hỏi" value="{{$question->question_title}}">
                        <input class="float-right mt-1" type="file" name="question_img" id="question-img"><label for=""></label>
                        @if ($question->question_img !='')
                            <img src="{{asset($question->question_img)}}" alt="" width="35px" height="35px">
                        @endif
                    </div>
                    <hr><Strong>Câu trả lời:</Strong>

                    <div class="mb-3">
                        <table class="table table table-borderless table-striped">
                            <tr>
                                <th>Lựa chọn:</th>
                                <th width="20%" >Đáp án đúng:</th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group mb-3">
                                        <label for="answer-A">Lựa chọn A:<span class="text-danger">*</span></label>
                                        <input type="text" id="answer-A" name="answer_A" class="form-control" placeholder="" value="{{$question->ans_1}}">
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="ans_1" name="correct_answer" 
                                    @if ($question->ans_1 == $question->corr_ans)  checked  @endif > 
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-group mb-3">
                                        <label for="answer-B">Lựa chọn B:<span class="text-danger">*</span></label>
                                        <input type="text" id="answer-B" name="answer_B" class="form-control" placeholder="" value="{{$question->ans_2}}">
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="ans_2" name="correct_answer"
                                    @if ($question->ans_2 == $question->corr_ans)  checked  @endif > 
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-group mb-3">
                                        <label for="answer-C">Lựa chọn C:</label>
                                        <input type="text" id="answer-C" name="answer_C" class="form-control" placeholder="" value="{{$question->ans_3}}">
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="ans_3" name="correct_answer" 
                                    @if ($question->ans_3 == $question->corr_ans)  checked  @endif > 
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <div class="form-group mb-3">
                                        <label for="answer-B">Lựa chọn D:</label>
                                        <input type="text" id="answer-D" name="answer_D" class="form-control" placeholder="" value="{{$question->ans_4}}">
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="ans_4" name="correct_answer" 
                                    @if ($question->ans_4 == $question->corr_ans)  checked  @endif > 
                                </td>
                            </tr>
                        </table>

                        <label for="mark">Điểm:</label>
                        <input type="number" step="0.05" name="mark" id="mark" value="{{$question->mark}}" placeholder="Điểm cho đáp án đúng">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    {{-- end modal --}}
@endsection

@section('script')
<script>
    const time_open = document.getElementById('time_open');
    const inlineRadio2 = document.getElementById('inlineRadio2');
    const inlineRadio1 = document.getElementById('inlineRadio1');
    inlineRadio2.addEventListener('change',function(){
        if(this.checked){
            time_open.disabled = true;
        }
    });
    inlineRadio1.addEventListener('change',function(){
        if(this.checked){
            time_open.disabled = false;
        }
    });
</script>
    {{-- <script>
        window.onbeforeunload = function() {
            return "";
        }
    </script> --}}
@endsection