@extends('teacher_layout')

@section('teacher_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('/teacher/exam')}}">Quản lý bài kiểm tra</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$exam->title}}</li>
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
    <!-- mainform -->
    <div class="row" >
        <div class="col-12 col-lg-4">
            <form class="" action="{{URL::to('/teacher/exam/postEditExam/'.$exam->id.'')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="card-box shadow p-4">
                    <h4 class="mb-3">Thông tin bài kiểm tra:</h4>

                    <div class="form-group mb-3">
                        <label for="product-name">Tên bài kiểm tra:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tên bài kiểm tra" value="{{$exam->title}}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="class">Lớp:<span class="text-danger">*</span></label>
                        <input type="text" id="class" name="class" class="form-control" value="{{$exam->cclass->class_name}}" disabled disabled>
                    </div>

                    <div class="form-group mb-3">
                            <label for="duration">Thời gian làm bài (phút):<span class="text-danger">*</span></label>
                            <input type="number" id="duration" name="duration" class="form-control" placeholder="Thời gian làm bài (phút)" value="{{$exam->duration}}">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="mb-2">Loại bài kiểm tra:<span class="text-danger">*</span></label>
                        <br/>
                        <div class="radio form-check-inline mr-4">
                            <label for="inlineRadio1">
                                <input type="radio" id="inlineRadio1" value="exam" name="type" @if ($exam->type =='exam') checked @endif > 
                                Kiểm tra thường:
                            </label>
                        </div>
                        <div class="radio form-check-inline">
                            <label for="inlineRadio2">
                                <input type="radio" id="inlineRadio2" value="exam_test" name="type" @if ($exam->type =='exam_test') checked @endif >
                                    Kiểm tra thử:
                            </label>
                        </div>           
                    </div>

                    <div class="form-group mb-3">
                            <label for="time_open">Thời gian mở đề:</span></label>
                            <input type="datetime-local" id="time_open" name="time_open" class="form-control" placeholder="Thời gian mở đề" 
                                @if ($exam->time_open !='')
                                    value="{{$exam->time_open->format('Y-m-d\TH:i')}}">
                                @else
                                    disabled >
                                @endif 
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-2">Trạng thái</label>
                        <br/>
                        <div class="radio form-check-inline mr-4">
                            <label for="inlineRadio3">
                                <input type="radio" id="inlineRadio3" value="1" name="status" @if ($exam->status =='1') checked @endif> 
                                Đã soạn xong đề
                            </label>
                        </div>
                        <div class="radio form-check-inline">
                            <label for="inlineRadio4">
                            <input type="radio" id="inlineRadio4" value="0" name="status" @if ($exam->status =='0') checked @endif>
                                Đang soạn đề
                            </label>
                        </div>
                        @if (($exam->status =='1'))
                        <p class="font-italic">Bài kiểm tra đã soạn xong sẽ không thể sửa</p>
                        @endif
                    </div>

                    <div class="text-center mb-3" >
                        <button type="submit" class="btn btn-primary" @if($exam->status =='1')disabled @endif>Lưu</button>
                    </div>
                </div>
            </form>            
        </div>
        <!-- end col -->

        <div class="col-12 col-lg-8">
            <div class="card-box shadow p-3">
                <div class="card-header p-0 mb-3">
                    <h4 class="d-inline-block ml-3">Câu hỏi:  <span class="badge badge-info">{{$exam->question->count()}}</span></h4>
                    <h4 class="d-inline-block">Tổng điểm:  <span class="badge badge-success">{{$exam->total_marks}}</span></h4>
                    <!-- button -->
                    <div class="d-inline-block float-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQuestion" @if($exam->status =='1')disabled @endif>
                            <i class="fas fa-pen pr-2"></i>Thêm
                        </button>
                    </div>
                    <!-- end button -->
                </div>

                <div class="question-scroll-container">
                    <div class="table-responsive">
                       <table class="align-middle table table-borderless table-striped">
                          <tbody>
                            {{-- question --}}
                            @foreach ($exam->question as $qu)
                             <tr>
                                <td>
                                   <b>{{$loop->index+1}}. {{ Str::limit($qu->question_title, 90)}} <span class="badge badge-info">{{$qu->mark}}đ</span></b><br>
                                   @if ($qu->question_img !='')
                                       <img src="{{asset($qu->question_img)}}" alt="" style="width: 40px; height: auto; display:block;">
                                   @endif
                                
                                   <span class="pl-3 
                                        @if ($qu->corr_ans == 'ans_1')
                                        text-success font-weight-bold
                                        @endif">A. {{ Str::limit($qu->ans_1, 90)}}
                                    </span><br>
                                   <span class="pl-3 
                                    @if ($qu->corr_ans == 'ans_2')
                                        text-success font-weight-bold
                                        @endif"> B. {{ Str::limit($qu->ans_2, 90)}}</span><br>
                                   @if($qu->ans_3 !='')
                                   <span class="pl-3
                                        @if ($qu->corr_ans == 'ans_3')
                                            text-success font-weight-bold
                                            @endif">C. {{ Str::limit($qu->ans_3, 90)}}</span><br>
                                    @endif
                                    @if($qu->ans_4 !='')
                                   <span class="pl-3 
                                    @if ($qu->corr_ans == 'ans_4')
                                        text-success font-weight-bold
                                        @endif">D. {{ Str::limit($qu->ans_4, 90)}}</span><br>
                                    @endif
                                </td>
                                <td class="text-center align-middle" width="20%">
                                    <a href="{{URL::to('teacher/exam/getEditQuestion/'.$qu->id.'')}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-edit"></i></a>
                                    <a onclick="deleteConfirm()" href="{{URL::to('teacher/exam/deleteQuestion/'.$qu->id.'')}}" class="action-icon text-danger" style="font-size: 25px;"><i class="far fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                          </tbody>
                       </table>
                    </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                       <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; height: 400px; right: 0px;">
                       <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 394px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- modal add question & answer --}}
    <div class="modal fade pt-4" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="addQuestion" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content mt-4">
                <form class="" action="{{URL::to('teacher/exam/postAddQuestion/'.$exam->id.'')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Thêm câu hỏi:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="question"> <strong>Câu hỏi:</strong> <span class="text-danger">*</span></label>
                            <input type="text" id="question" name="question" class="form-control" placeholder="Câu hỏi">
                            <input class="float-right mt-1" type="file" name="question_img" id="question-img"><label for=""></label>
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
                                            <input type="text" id="answer-A" name="answer_A" class="form-control" placeholder="">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="ans_1" name="correct_answer" checked> 
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group mb-3">
                                            <label for="answer-B">Lựa chọn B:<span class="text-danger">*</span></label>
                                            <input type="text" id="answer-B" name="answer_B" class="form-control" placeholder="">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="ans_2" name="correct_answer"> 
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group mb-3">
                                            <label for="answer-C">Lựa chọn C:</label>
                                            <input type="text" id="answer-C" name="answer_C" class="form-control" placeholder="">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="ans_3" name="correct_answer" > 
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <div class="form-group mb-3">
                                            <label for="answer-B">Lựa chọn D:</label>
                                            <input type="text" id="answer-D" name="answer_D" class="form-control" placeholder="">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="ans_4" name="correct_answer"> 
                                    </td>
                                </tr>
                            </table>

                            <label for="mark">Điểm:</label>
                            <input type="number" step="0.05" name="mark" id="mark" value="1" placeholder="Điểm cho đáp án đúng">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal --}}
    {{-- modal edit question & answer --}}
    <div class="modal fade pt-4" id="eidtQuestion" tabindex="-1" role="dialog" aria-labelledby="addQuestion" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content mt-4">
                <form class="" action="{{URL::to('teacher/exam/postEditQuestion/'.$exam->id.'')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Thêm câu hỏi:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <p>???</p>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="question"> <strong>Câu hỏi:</strong> <span class="text-danger">*</span></label>
                            <input type="text" id="question" name="question" class="form-control" placeholder="Câu hỏi">
                            <input class="float-right mt-1" type="file" name="question_img" id="question-img"><label for=""></label>
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
                                            <input type="text" id="answer-A" name="answer_A" class="form-control" placeholder="">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="A" name="correct_answer" checked> 
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group mb-3">
                                            <label for="answer-B">Lựa chọn B:<span class="text-danger">*</span></label>
                                            <input type="text" id="answer-B" name="answer_B" class="form-control" placeholder="">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="B" name="correct_answer"> 
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-group mb-3">
                                            <label for="answer-C">Lựa chọn C:</label>
                                            <input type="text" id="answer-C" name="answer_C" class="form-control" placeholder="">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="C" name="correct_answer" > 
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <div class="form-group mb-3">
                                            <label for="answer-B">Lựa chọn D:</label>
                                            <input type="text" id="answer-D" name="answer_D" class="form-control" placeholder="">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="radio" style="width: 2rem" class="form-control-lg" id="correct-answer" value="D" name="correct_answer"> 
                                    </td>
                                </tr>
                            </table>

                            <label for="mark">Điểm:</label>
                            <input type="number" step="0.05" name="mark" id="mark" value="1" placeholder="Điểm cho đáp án đúng">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
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
@endsection