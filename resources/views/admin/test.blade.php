@extends('admin_layout')

@section('admin_content')
        {{$teacher->id}} <hr>
        {{$teacher->name}} <hr>
        {{$teacher->email}} <hr>
        {{$teacher->gender}} <hr>
              
        @foreach ($teacher->subject as $subj)
            {{$subj->id}}<br>{{$subj->subject_name}}
        @endforeach
                    <hr>
       {{$teacher->avatar}}
                            <hr>
        {{$teacher->status}}
                              
                                
@endsection

