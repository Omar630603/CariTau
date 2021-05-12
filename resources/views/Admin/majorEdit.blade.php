@extends('layouts.adminApp')
@section('content')
<div class="container">
    <div style="margin-top: 20px;">
        <div style="margin-left: 40px; display: flex; flex-direction: column" class="float-right my-2">
            <div style="text-align: center">
                <img width="120px" height="120px" style="border-radius: 10%;" src="{{asset('storage/'.$major->image)}}">
            </div>
            <a style="margin-top: 10px; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href=""
                onclick="$('#imageInput').show(); return false;">Change Picture</a>
            <form method="POST" action="">
                @csrf
                <button type="submit"
                    style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                    class="btn btn-info">Restore
                    Default</button>
            </form>
            <form method="post" style="display: none; margin-top: 10px" id="imageInput" action=""
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input style="border: none" onchange="document.getElementById('upload').click();" type="file"
                    name="image">
                <input type="submit" style="display: none;" name="upload" id="upload">
                <i class="fa fa-close" style="margin-right: 15px; font-size:24px; cursor: pointer;"
                    onclick="$('#imageInput').hide();return false;">
                </i>
            </form>
        </div>
        <form method="post" action="" enctype="multipart/form-data" class="card-body" style="padding: 0;">
            @csrf
            <div class="form-group row">
                <label style="margin-bottom: 0" for="major_name">Major Name:</label>
                <input class="form-control" name="major_name" type="text" placeholder="{{$major->major_name}}"
                    value="{{$major->major_name}}">
            </div>
            <div class="form-group row">
                <label style="margin-bottom: 0" for="description">Major Description:</label>
                <textarea class="form-control" name="description" type="text" placeholder="{{$major->description}}"
                    value="{{$major->description}}"></textarea>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary">Done</button>
            </div>

        </form>
    </div>
    <div class="form-group row">
        <a class="btn btn-success">Add New Course</a>
    </div>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach ($courses as $course)
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#collapse{{$course->ID_course}}" aria-expanded="false"
                        aria-controls="collapse{{$course->ID_course}}">
                        {{$course->course_name}}
                    </a>
                </h4>
            </div>
            <div id="collapse{{$course->ID_course}}" class="panel-collapse collapse" role="tabpanel"
                aria-labelledby="heading{{$course->ID_course}}">
                <div class="panel-body">
                    <div class="control-major action-major">
                        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href="">Edit
                            Course Data</a>
                    </div>
                    <div class="control-major">
                        <b>Description</b>:<br>{{$course->description}}<br>
                    </div>
                    <div class="control-major">

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection