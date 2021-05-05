@extends('layouts.adminApp')
@section('content')
<div class="container">
    @if (!in_array($user->ID_user, $adminLecturers))
    <h2>Student</h2>
    <div class="bio-data" style="display: flex; justify-content: space-between">
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
        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href="">Edit Bio Data</a>
        <a class="btn btn-danger" href="">Delete Student</a>
        <a class="btn btn-success" href="">Add Course</a>
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
                    <td data-label="Course Name">{{$Course->course_name}}</td>
                    @if ($Course->pivot->status)
                    <td data-label="Course Status">Full</a></td>
                    @else
                    <td data-label="Course Status">Preview</a></td>
                    @endif
                    <td style="display: flex; justify-content: space-around">
                        <a style="color: white; background-color: rgb(21, 74, 172)" class="btn btn-info"
                            href="">Edit</a>
                        <a style="color: white" class="btn btn-danger" href="">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif(in_array($user->ID_user, $lecturers))
    <h2>Lecturer</h2>
    <div class="bio-data" style="display: flex; justify-content: space-between">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name :{{$user->name}}</li>
            <li class="list-group-item">User Name :{{$user->username}}</li>
            <li class="list-group-item">E-Mail :{{$user->email}}</li>
            <li class="list-group-item">Address :{{$user->address}}</li>
            <li class="list-group-item">Phone :{{$user->phone}}</li>
        </ul>
        <div class="float-right my-2">
            <img width="225px" height="225px" style="border-radius: 10%" src="{{asset('storage/'.$user->image)}}">
        </div>
    </div>
    <div class="action" style="margin-top: 20px">
        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href="">Edit Bio Data</a>
        <a class="btn btn-danger" href="">Delete Lecturer</a>
        <a class="btn btn-success" href="">Add Course</a>
    </div>
    <div class="users-table" style="margin-top: 50px">
        <table>
            <caption>Lecturer: {{$user->name}}'s Course</caption>
            <thead>
                <tr>
                    <th scope="col">Course Name</th>
                    <th scope="col">Course Price/Student</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="Course Name">{{$lecturerCourse[0]->course_name}}</td>
                    <td data-label="Course Price/Student">{{$lecturerCourse[0]->price}}</td>
                    <td style="display: flex; justify-content: space-around">
                        <a style="color: white; background-color: rgb(21, 74, 172)" class="btn btn-info"
                            href="">Edit</a>
                        <a style="color: white" class="btn btn-danger" href="">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @elseif(in_array($user->ID_user, $admins))
    <h2>Admin</h2>
    <div class="bio-data" style="display: flex; justify-content: space-between">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Name :{{$user->name}}</li>
            <li class="list-group-item">User Name :{{$user->username}}</li>
            <li class="list-group-item">E-Mail :{{$user->email}}</li>
            <li class="list-group-item">Address :{{$user->address}}</li>
            <li class="list-group-item">Phone :{{$user->phone}}</li>
        </ul>
        <div class="float-right my-2">
            <img width="225px" height="225px" style="border-radius: 10%" src="{{asset('storage/'.$user->image)}}">
        </div>
    </div>
    <div class="action" style="margin-top: 20px">
        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info" href="">Edit Bio Data</a>
        <a class="btn btn-danger" href="">Delete Admin</a>
    </div>
    @endif
</div>
@endsection