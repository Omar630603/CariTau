@extends('layouts.adminApp')
@section('content')
<div class="container">
    <div>
        @if ($message = Session::get('fail'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
    </div>
    <div style="margin-top: 20px;">
        <div style="margin-left: 40px; display: flex; flex-direction: column" class="float-right my-2">
            <div style="text-align: center">
                <img width="120px" height="120px" style="border-radius: 10%;" src="{{asset('storage/'.$major->image)}}">
            </div>
            <a style="margin-top: 10px; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href=""
                onclick="$('#imageInput').show(); return false;">Change Picture</a>
            <form method="POST" action="{{route('majorAdmin.restoreImage', $major)}}">
                @csrf
                <button type="submit"
                    style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                    class="btn btn-info">Restore
                    Default</button>
            </form>
            <form method="post" style="display: none; margin-top: 10px" id="imageInput"
                action="{{route('majorAdmin.updateImage', $major)}}" enctype="multipart/form-data">
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
        <form method="post" action="{{route('majorAdmin.update', $major)}}" enctype="multipart/form-data"
            class="card-body" style="padding: 0;">
            @csrf
            <div class="form-group row">
                <label style="margin-bottom: 0" for="major_name">Major Name:</label>
                <input class="form-control" name="major_name" type="text" placeholder="{{$major->major_name}}"
                    value="{{$major->major_name}}">
            </div>
            <div class="form-group row">
                <label style="margin-bottom: 0" for="description">Major Description:</label>
                <textarea rows="5" class="form-control" name="description" type="text"
                    placeholder="{{$major->description}}" value="{{$major->description}}"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Done</button>
            </div>
        </form>
        <form style="display: none" action="{{ route('majorAdmin.delete', $major) }}" method="POST">
            @csrf
            @method('DELETE')
            <button id="delete" type="submit"></button>
        </form>
    </div>
    <div style="display: flex; justify-content: space-between" class="form-group">
        <a class="btn btn-success" onclick="addUser()">Add New Course</a>
        <a class="btn btn-danger" onclick="document.getElementById('delete').click();">Delete {{$major->major_name}}</a>
    </div>
    <div class="AddUserTable" style="display: none; width: 100%" id="addForm">
        <form method="POST" action="{{ route('admin.majorAddCourse', $major) }}">
            @csrf
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Course Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Course Name">
                            <input id="course_name" type="text" class="form-control" name="course_name">
                        </td>
                        <td data-label="Description">
                            <textarea rows="5" id="description" class="form-control" name="description"></textarea>
                        </td>
                        <td data-label="price">
                            <input id="price" type="text" class="form-control" name="price">
                        </td>
                    </tr>
                    <tr style="align-content: center">
                        <td>
                            <button id="courseLecturerBtn"
                                style="width: 100%; background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                type="submit" class="btn btn-primary">Add
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
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
                        <b>Lecturer:
                            @foreach ($lecturers as $lecturer)
                            @if ($lecturer->ID_course == $course->ID_course)
                            <a href="{{ route('admin.userDetails', $lecturer->ID_user) }}">
                                {{$lecturer->name}}
                            </a></b>
                        @endif
                        @endforeach
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
<script>
    function addUser() {
    var x = document.getElementById("addForm");
        if (x.style.display === "none") {
            x.style.display = "";
            x.style="animation: drop 0.5s ease;";
        } else {
            x.style.display = "none";
        }
    }
</script>
@endsection