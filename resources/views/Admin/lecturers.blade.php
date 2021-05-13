@extends('layouts.adminApp')
@section('content')
<div class="container">
    <div class="form-group">
        <a onclick="addUser()" class="btn btn-success">Add New Lecturer</a>
    </div>
    <div class="AddUserTable" style="display: none; width: 100%" id="addForm">
        <div id="alertCourse" style="display: none; text-align: left;" class="alert alert-info">
            <p style="text-align: left;">You can't add new lecturer because all the courses have been
                taken<br><a href="">Add new
                    course to assign it to new lecturer</a>
            </p>
        </div>
        <form method="POST" action="{{ route('register.lecturerAdmin') }}">
            @csrf
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">User Name</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Password</th>
                        <th scope="col">Course</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Full Name">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        </td>
                        <td data-label="User Name">
                            <input id="username" type="text"
                                class="form-control @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username') }}" required autocomplete="username">
                        </td>
                        <td data-label="E-Mail">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                        </td>
                        <td data-label="Phone">
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                        </td>
                        <td data-label="Address">
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                name="address" value="{{ old('address') }}" required autocomplete="address">
                        </td>
                        <td data-label="Password">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                        </td>
                        <td data-label="Course">
                            <select id="courseLecturer" name="course" class="form-control">
                                @foreach ($courses as $course)
                                @if(!in_array($course->ID_course, $availableCourses))
                                <option value="{{$course->ID_course}}">{{$course->course_name}}
                                </option>
                                @endif
                                @endforeach
                            </select>
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
    <h3>Lecturers in CariTau: {{count($lecturers)}}</h3>
    <div class="main center">
        @foreach ($lecturers as $lecturer)
        <div class="box center">
            <a href="{{ route('admin.userDetails', $lecturer->ID_user) }}">
                <img src="{{asset('storage/'.$lecturer->image)}}" alt="">
            </a>
            <div>
                <p class="user_name">{{$lecturer->name}}</p>
                @foreach ($courses as $course)
                @if ($lecturer->ID_course == $course->ID_course)
                <p class="skill">{{$course->course_name}}</p>
                @endif
                @endforeach
            </div>
            <div id="arr_container{{$lecturer->ID_user}}" onclick="openCard({{$lecturer->ID_user}})"
                class="arr_container center">
                <i class="fas fa-arrow-right"></i>
            </div>
            <div id="left_container{{$lecturer->ID_user}}" class="left_container off">
                <p>Info</p>
                <div class="skills">
                    <div>{{$lecturer->username}}</div>
                    <div>{{$lecturer->email}}</div>
                    <div>{{$lecturer->phone}}</div>
                    <div>{{$lecturer->address}}</div>
                </div>
                <div id="cancel{{$lecturer->ID_user}}" onclick="openCard({{$lecturer->ID_user}})" class="cancel center">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    function openCard(id) {
    var clc = document.getElementById("cancel"+id);
    var arr = document.getElementById("arr_container"+id);
    var left_container = document.getElementById("left_container"+id);
        if (left_container.classList.contains("off")) {
            left_container.classList.remove("off");
            left_container.classList.add("active");
        } else {
            left_container.classList.remove("active");
            left_container.classList.add("off");
        }
    }
</script>
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
    var s = document.getElementById("courseLecturer");
    var sb = document.getElementById("courseLecturerBtn");
    var sa = document.getElementById("alertCourse");
    if (s.length == 0) {
        s.disabled = true
        sb.disabled = true
        sa.style.display = "";
    }
</script>
@endsection