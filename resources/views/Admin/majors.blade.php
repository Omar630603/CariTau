@extends('layouts.adminApp')
@section('content')
<div class="container">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach ($majors as $major)
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{$major->ID_major}}">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#collapse{{$major->ID_major}}" aria-expanded="false"
                        aria-controls="collapse{{$major->ID_major}}">
                        {{$major->major_name}}
                    </a>
                </h4>
            </div>
            <div id="collapse{{$major->ID_major}}" class="panel-collapse collapse" role="tabpanel"
                aria-labelledby="heading{{$major->ID_major}}">
                <div class="panel-body">
                    <div class="control-major action-major">
                        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
                            href="{{route('admin.major', $major)}}">Edit
                            Major Data</a>
                        <img width="50px" height="50px" style="margin-top: 10px; border-radius: 10%;"
                            src="{{asset('storage/'.$major->image)}}">
                    </div>
                    <div class="control-major">
                        <b>Description</b>:<br>{{$major->description}}<br>
                    </div>
                    <div class="control-major">
                        <b>Courses</b>:<br>
                        @foreach ($courses as $course)
                        @if ($course->ID_major==$major->ID_major)
                        <a href="">{{$course->course_name}}</a><br>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection