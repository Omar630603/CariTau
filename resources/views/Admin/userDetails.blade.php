@extends('layouts.adminApp')
@section('content')
<div class="container">
    @if (!in_array($user->ID_user, $adminLecturers))
    <h2>Student</h2>
    <div id="edit_biodata" class="bio-data" style="display: none; animation: slideL2R 0.5s">
        <form method="post" action="{{ route('userAdmin.update', $user) }}" enctype="multipart/form-data"
            class="card-body" style="padding: 0; margin-left: 15px">
            @csrf
            <div class="form-group row" style="margin-right: 20px;">
                <label style="margin-bottom: 0" for="name">Name:</label>
                <input class="form-control" name="name" type="text" placeholder="{{$user->name}}"
                    value="{{$user->name}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="username">User Name:</label>
                <input class="form-control" name="username" type="text" placeholder="{{$user->username}}"
                    value="{{$user->username}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="email">E-Mail:</label>
                <input class="form-control" name="email" type="text" placeholder="{{$user->email}}"
                    value="{{$user->email}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="address">Address:</label>
                <input class="form-control" name="address" type="text" placeholder="{{$user->address}}"
                    value="{{$user->address}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="phone">Phone:</label>
                <input class="form-control" name="phone" type="text" placeholder="{{$user->phone}}"
                    value="{{$user->phone}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <button type="submit" class="btn btn-primary">Done</button>
            </div>
        </form>
        <i class="fa fa-close" style="margin-right: 15px; font-size:24px; cursor: pointer;"
            onclick="$('#edit_biodata').hide(); $('#bio_data').show(); return false;">
        </i>
        <div style="display: flex; flex-direction: column" class="float-right my-2">
            <div style="text-align: center">
                <img width="220px" height="220px" style="border-radius: 10%" src="{{asset('storage/'.$user->image)}}">
            </div>
            <a style="margin-top: 10px; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href=""
                onclick="$('#imageInput').show(); return false;">Change Picture</a>
            <form method="POST" action="{{ route('userAdmin.restoreImage', $user) }}">
                @csrf
                <button type="submit"
                    style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                    class="btn btn-info">Restore
                    Default</button>
            </form>
            <form method="post" style="display: none; margin-top: 10px" id="imageInput"
                action="{{ route('userAdmin.updateImage', $user) }}" enctype="multipart/form-data">
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
    </div>
    <div id="bio_data" class="bio-data" style="animation: drop 0.5s">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name :{{$user->name}}</li>
            <li class="list-group-item">User Name :{{$user->username}}</li>
            <li class="list-group-item">E-Mail :{{$user->email}}</li>
            <li class="list-group-item">Address :{{$user->address}}</li>
            <li class="list-group-item">Phone :{{$user->phone}}</li>
        </ul>
        <div class="float-right my-2">
            <img width="220px" height="220px" style="border-radius: 10%" src="{{asset('storage/'.$user->image)}}">
        </div>
    </div>
    <div class="action" style="margin-top: 20px">
        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href=""
            onclick="$('#bio_data').hide(); $('#edit_biodata').show(); return false;">Edit Bio Data</a>
        <a class="btn btn-danger" onclick="document.getElementById('delete').click();">Delete Student</a>
        <form style="display: none" action="{{ route('userAdmin.delete', $user) }}" method="POST">
            @csrf
            @method('DELETE')
            <button id="delete" type="submit"></button>
        </form>
        <a class="btn btn-success" href="" onclick="addUser(1); return false;">Add Course</a>
    </div>
    <div class="AddUserTable" style="display: none" id="addForm1">
        <div id="alertStudent" style="margin-top: 10px; display: none" class="alert alert-info">
            <p>There are no available courses because all the courses have been taken by the student: {{$user->name}}
            </p>
        </div>
        <form method="POST" action="{{ route('userAdmin.addStudentCourse', $user) }}">
            @csrf
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Course</th>
                        <th scope="col">Course Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Course">
                            <select id="courseStudent" name="course" class="form-control">
                                @foreach ($courses as $course)
                                @if(!in_array($course->ID_course, $availableCourses))
                                <option value="{{$course->ID_course}}">{{$course->course_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                        <td data-label="Full Name">
                            <select id="courseStudentStatus" name="status" class="form-control">
                                <option value="0">Preview</option>
                                <option value="1">Full</option>
                            </select>
                        </td>
                    </tr>
                    <tr style="align-content: center">
                        <td>
                            <button id="courseStudentBtn"
                                style="width: 100%; background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                type="submit" class="btn btn-primary">Add
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class="users-table" style="margin-top: 30px">
        <table>
            <caption>Student: {{$user->name}} Enrollments' Table</caption>
            <thead>
                <tr>
                    <th scope="col">Course Name</th>
                    <th scope="col">Course Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userCourse as $Course)
                <tr>
                    <td data-label="Course Name"><a href="">{{$Course->course_name}}</a></td>
                    @if ($Course->pivot->status)
                    <td data-label="Course Status">Full</a></td>
                    @else
                    <td data-label="Course Status">Preview</a></td>
                    @endif
                    <td style="display: flex; justify-content: space-around">
                        <a style="color: white; background-color: rgb(21, 74, 172)" class="btn btn-info" href=""
                            onclick="$('#editStudentCourseStatus{{$Course->ID_course}}').show(); return false;">Edit</a>
                        <a style="color: white" class="btn btn-danger" href=""
                            onclick="document.getElementById('deleteCourse{{$Course->ID_course}}').click();return false;">Delete</a>
                        <form style="display: none"
                            action="{{ route('userAdmin.deleteStudentCourse', ['Course'=>$Course,'user'=>$user]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button id="deleteCourse{{$Course->ID_course}}" type="submit"></button>
                        </form>
                    </td>
                </tr>
                <tr id="editStudentCourseStatus{{$Course->ID_course}}" style="display: none">
                    <td>Change This course: {{$Course->course_name}} status
                        <form method="post"
                            action="{{ route('userAdmin.editStudentCourse', ['course'=>$Course->pivot->ID_course,'user'=>$user]) }}"
                            enctype="multipart/form-data" style="display: flex">
                            @csrf
                            @method('PUT')
                            <select style="margin-top: 5px" name="status" class="form-control">
                                <option value="" disabled selected>Select your option</option>
                                <option value="0">Preview</option>
                                <option value="1">Full</option>
                            </select>
                            <div style="margin-top: 5px; margin-left: 10px">
                                <button type="submit" class="btn btn-primary">Done</button>
                            </div>
                            <i class="fa fa-close"
                                style="margin-top: 10px; margin-left: 10px; font-size:24px; cursor: pointer;"
                                onclick="$('#editStudentCourseStatus{{$Course->ID_course}}').hide();return false;">
                            </i>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif(in_array($user->ID_user, $lecturers))
    <h2>Lecturer</h2>
    <div id="edit_biodata" class="bio-data" style="display: none; animation: slideL2R 0.5s">
        <form method="post" action="{{ route('userAdmin.update', $user) }}" enctype="multipart/form-data"
            class="card-body" style="padding: 0; margin-left: 15px">
            @csrf
            <div class="form-group row" style="margin-right: 20px;">
                <label style="margin-bottom: 0" for="name">Name:</label>
                <input class="form-control" name="name" type="text" placeholder="{{$user->name}}"
                    value="{{$user->name}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="username">User Name:</label>
                <input class="form-control" name="username" type="text" placeholder="{{$user->username}}"
                    value="{{$user->username}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="email">E-Mail:</label>
                <input class="form-control" name="email" type="text" placeholder="{{$user->email}}"
                    value="{{$user->email}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="address">Address:</label>
                <input class="form-control" name="address" type="text" placeholder="{{$user->address}}"
                    value="{{$user->address}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="phone">Phone:</label>
                <input class="form-control" name="phone" type="text" placeholder="{{$user->phone}}"
                    value="{{$user->phone}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <button type="submit" class="btn btn-primary">Done</button>
            </div>
        </form>
        <i class="fa fa-close" style="margin-right: 15px; font-size:24px; cursor: pointer;"
            onclick="$('#edit_biodata').hide(); $('#bio_data').show(); return false;">
        </i>
        <div style="display: flex; flex-direction: column" class="float-right my-2">
            <div style="text-align: center">
                <img width="220px" height="220px" style="border-radius: 10%" src="{{asset('storage/'.$user->image)}}">
            </div>
            <a style="margin-top: 10px; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href=""
                onclick="$('#imageInput').show(); return false;">Change Picture</a>
            <form method="POST" action="{{ route('userAdmin.restoreImage', $user) }}">
                @csrf
                <button type="submit"
                    style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                    class="btn btn-info">Restore
                    Default</button>
            </form>
            <form method="post" style="display: none; margin-top: 10px" id="imageInput"
                action="{{ route('userAdmin.updateImage', $user) }}" enctype="multipart/form-data">
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
    </div>
    <div id="bio_data" class="bio-data" style="animation: drop 0.5s">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name :{{$user->name}}</li>
            <li class="list-group-item">User Name :{{$user->username}}</li>
            <li class="list-group-item">E-Mail :{{$user->email}}</li>
            <li class="list-group-item">Address :{{$user->address}}</li>
            <li class="list-group-item">Phone :{{$user->phone}}</li>
        </ul>
        <div class="float-right my-2">
            <img width="220px" height="220px" style="border-radius: 10%" src="{{asset('storage/'.$user->image)}}">
        </div>
    </div>
    <div class="action" style="margin-top: 20px">
        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href=""
            onclick="$('#bio_data').hide(); $('#edit_biodata').show(); return false;">Edit Bio Data</a>
        <a class="btn btn-danger" onclick="document.getElementById('delete').click();">Delete Lecturer</a>
        <form style="display: none" action="{{ route('userAdmin.delete', $user) }}" method="POST">
            @csrf
            @method('DELETE')
            <button id="delete" type="submit"></button>
        </form>
    </div>
    <div class="users-table" style="margin-top: 50px">
        <table>
            <caption>Lecturer: {{$user->name}}'s Course</caption>
            <thead>
                <tr>
                    <th scope="col">Course Name</th>
                    <th scope="col">Course Price/Student</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="Course Name"><a
                            href="{{ route('admin.courseDetails', $lecturerCourse[0]) }}">{{$lecturerCourse[0]->course_name}}</a>
                    </td>
                    <td data-label="Course Price/Student">{{$lecturerCourse[0]->price}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @elseif(in_array($user->ID_user, $admins))
    <h2>Admin</h2>
    <div id="edit_biodata" class="bio-data" style="display: none; animation: slideL2R 0.5s">
        <form method="post" action="{{ route('userAdmin.update', $user) }}" enctype="multipart/form-data"
            class="card-body" style="padding: 0; margin-left: 15px">
            @csrf
            <div class="form-group row" style="margin-right: 20px;">
                <label style="margin-bottom: 0" for="name">Name:</label>
                <input class="form-control" name="name" type="text" placeholder="{{$user->name}}"
                    value="{{$user->name}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="username">User Name:</label>
                <input class="form-control" name="username" type="text" placeholder="{{$user->username}}"
                    value="{{$user->username}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="email">E-Mail:</label>
                <input class="form-control" name="email" type="text" placeholder="{{$user->email}}"
                    value="{{$user->email}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="address">Address:</label>
                <input class="form-control" name="address" type="text" placeholder="{{$user->address}}"
                    value="{{$user->address}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <label style="margin-bottom: 0" for="phone">Phone:</label>
                <input class="form-control" name="phone" type="text" placeholder="{{$user->phone}}"
                    value="{{$user->phone}}">
            </div>
            <div class="form-group row" style="margin-right: 20px">
                <button type="submit" class="btn btn-primary">Done</button>
            </div>
        </form>
        <i class="fa fa-close" style="margin-right: 15px; font-size:24px; cursor: pointer;"
            onclick="$('#edit_biodata').hide(); $('#bio_data').show(); return false;">
        </i>
        <div style="display: flex; flex-direction: column" class="float-right my-2">
            <div style="text-align: center">
                <img width="220px" height="220px" style="border-radius: 10%" src="{{asset('storage/'.$user->image)}}">
            </div>
            <a style="margin-top: 10px; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href=""
                onclick="$('#imageInput').show(); return false;">Change Picture</a>
            <form method="POST" action="{{ route('userAdmin.restoreImage', $user) }}">
                @csrf
                <button type="submit"
                    style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                    class="btn btn-info">Restore
                    Default</button>
            </form>
            <form method="post" style="display: none; margin-top: 10px" id="imageInput"
                action="{{ route('userAdmin.updateImage', $user) }}" enctype="multipart/form-data">
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
    </div>
    <div id="bio_data" class="bio-data" style="animation: drop 0.5s">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name :{{$user->name}}</li>
            <li class="list-group-item">User Name :{{$user->username}}</li>
            <li class="list-group-item">E-Mail :{{$user->email}}</li>
            <li class="list-group-item">Address :{{$user->address}}</li>
            <li class="list-group-item">Phone :{{$user->phone}}</li>
        </ul>
        <div class="float-right my-2">
            <img width="220px" height="220px" style="border-radius: 10%" src="{{asset('storage/'.$user->image)}}">
        </div>
    </div>
    <div class="action" style="margin-top: 20px">
        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href=""
            onclick="$('#bio_data').hide(); $('#edit_biodata').show(); return false;">Edit Bio Data</a>
        <a class="btn btn-danger" onclick="document.getElementById('delete').click();">Delete Admin</a>
        <form style="display: none" action="{{ route('userAdmin.delete', $user) }}" method="POST">
            @csrf
            @method('DELETE')
            <button id="delete" type="submit"></button>
        </form>
    </div>
    @endif
</div>
<script>
    function addUser(id) {
    var x = document.getElementById("addForm"+id);
    if (x.style.display === "none") {
        x.style.display = "";
        x.style="animation: drop 0.5s ease; margin-top: 20px;";
    } else {
        $('#addForm'+id).slideUp();
    }
    }
    var s = document.getElementById("courseStudent");
    var ss = document.getElementById("courseStudentStatus");
    var sb = document.getElementById("courseStudentBtn");
    var sa = document.getElementById("alertStudent");
    if (s.length == 0) {
        s.disabled = true
        ss.disabled = true
        sb.disabled = true
        sa.style.display = "";
    }
</script>
@endsection