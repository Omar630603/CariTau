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