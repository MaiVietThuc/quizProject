@extends('teacher_layout')

@section('teacher_content')
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="{{URL::to('/teacher')}}"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Quản lý phản hồi</li>
        </ol>
    </nav>

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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-2 font-weight-bold text-primary d-inline-block">Danh sách phản hồi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tên sinh viên</th>                          
                            <th>Avatar</th>
                            <th>Bài kiểm tra</th>
                            <th>Nội dung</th>
                            <th>Phản hổi</th>
                            <th>Trả lời</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feedback as $fb)
                            <tr>
                                <td>fb-{{$fb->student->name}}</td>                        
                                <td>
                                    @if ($fb->student->avatar =='')
                                        <img src="{{asset('/img/user.png')}}" alt="" width="35px" height="35px">
                                    @else
                                    <img src="{{asset($fb->student->avatar)}}" alt="" width="35px" height="35px">
                                    @endif
                                </td>   
                                <td>{{$fb->exam->title}}</td>    
                                <td>{{$fb->student_feedback}}</td>                       
                                <td>
                                    @if ($fb->teacher_rep !='')
                                        {{$fb->teacher_rep}}
                                    @else
                                        Chưa phản hồi!
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{URL::to('teacher/feedback/repFeedback/'.$fb->id)}}" class="action-icon text-primary mr-2" style="font-size: 25px;"><i class="far fa-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                paging: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm..."
                },
                "columnDefs": [ {
                "targets": [3],
                "orderable": false
                } ]
            });
        });
    </script>    
@endsection