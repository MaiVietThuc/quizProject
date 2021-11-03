@extends('admin_layout')

@section('admin_content')
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('/admin/majors')}}">Quản lý chuyên ngành</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm chuyên ngành</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 pl-3">Thêm chuyên ngành</h1>
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
    <form class="" action="{{URL::to('/admin/postAddMajors')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card-box shadow col-10 ml-5  pt-3 pb-3">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Bắt buộc</h5>
                    
                    <div class="form-group mb-3">
                        <label for="product-name">Mã chuyên ngành:<span class="text-danger">*</span></label>
                        <input type="text" id="mcn" name="mcn" class="form-control" placeholder="Mã chuyên ngành">
                    </div>

                    <div class="form-group mb-3">
                        <label for="product-name">Tên chuyên ngành:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tên chuyên ngành">
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-2">Trạng thái</label>
                        <br/>
                        <div class="radio form-check-inline mr-4">
                            <label for="inlineRadio1">
                                <input type="radio" id="inlineRadio1" value="1" name="status" checked=""> 
                                Khả dụng:
                            </label>
                        </div>
                        <div class="radio form-check-inline">
                            <label for="inlineRadio2">
                                <input type="radio" id="inlineRadio2" value="0" name="status">
                                 Ẩn:
                            </label>
                        </div>
                
                    </div>

                    <div class="text-center mb-3" >
                        <a href="{{URL::to('/admin/majors')}}"><button type="button" class="btn btn-danger mr-3">Hủy</button></a>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>

                </div> <!-- end card-box -->
            </div> <!-- end col -->

        </div>
    </form>
@endsection

@section('script')
    <script>
        window.onbeforeunload = function() {
            return "";
        }
    </script>
@endsection