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
        @elseif ($message = Session::get('add'))
        <div class="alert alert-info">
            <p>{{ $message }}</p>
        </div>
        @endif
    </div>
    <div class="form-group">
        <a onclick="addUser()" class="btn btn-success">Add New Major</a>
    </div>
    <div class="AddUserTable" style="display: none; width: 100%" id="addForm">
        <form method="POST" action="{{ route('admin.majorAdd') }}">
            @csrf
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Major Name</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Major Name">
                            <input id="major_name" type="text" class="form-control" name="major_name">
                        </td>
                        <td data-label="Description">
                            <textarea rows="5" id="description" class="form-control" name="description"></textarea>
                        </td>
                    </tr>
                    <tr style="align-content: center">
                        <td>
                            <button id="courseLecturerBtn"
                                style="width: 100%; background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                type="submit" class="btn btn-primary">Create
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
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
                        <a href="{{route('admin.major', $major)}}"><img width="50px" height="50px"
                                style="margin-top: 10px; border-radius: 10%;"
                                src="{{asset('storage/'.$major->image)}}"></a>
                    </div>
                    <div class="control-major">
                        <b>Description</b>:<br>{{$major->description}}<br>
                    </div>
                    <div class="control-major">
                        <b>Courses</b>:<br>
                        @php $no = 1; @endphp
                        @foreach ($courses as $course)
                        @if ($course->ID_major==$major->ID_major)
                        <b>{{$no ++}}-
                            <a href="{{ route('admin.courseDetails', $course) }}">{{$course->course_name}}</a></b> <br>
                        <div class="control-major">
                            <b>Lecturer:</b>
                            @foreach ($lecturers as $lecturer)
                            @if ($lecturer->ID_course == $course->ID_course)
                            <a href="{{ route('admin.userDetails', $lecturer->ID_user) }}">
                                <b>{{$lecturer->name}}</b>
                            </a>
                            @else
                            @endif
                            @endforeach
                        </div>
                        @endif
                        @endforeach
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
            $('#addForm').slideUp();
        }
    }
</script>
@endsection