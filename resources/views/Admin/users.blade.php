@extends('layouts.adminApp')

@section('content')
<div class="navAdmin">
    <header>
        <nav>
            <ul>
                <li><a href="" onclick="$('#lecturer').hide(); $('#admin').hide(); $('#student').show()">Students</a>
                </li>
                <li><a href=""
                        onclick="$('#student').hide(); $('#admin').hide(); $('#lecturer').show();return false;">Lecturers</a>
                </li>
                <li><a href=""
                        onclick="$('#student').hide(); $('#lecturer').hide(); $('#admin').show();return false;">Admins</a>
                </li>
            </ul>
        </nav>
    </header>
</div>
<div class="container">
    <div id="student">
        @if ($message = Session::get('fail'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <h3>CariTau Students: {{$countS}}</h3>
        <div class="users-table">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left my-2">
                        <form method="get" action="{{ route('admin.search') }}" id="myForm">@csrf
                            <div style="display: flex; justify-content: space-between" class="form-group">
                                <input style="margin-right: 5px;" type="text" name="search" class="form-control"
                                    id="search" ariadescribedby="search" placeholder="Search">
                                <button
                                    style="background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                    type="submit" class="btn btn-primary">Find
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="float-right my-2">
                        <a style="background-color: rgb(21, 74, 172); font-weight: 800; color: white;  border:0"
                            class="btn btn-primary" onclick="addUser(1)">Create New User</a>
                    </div>
                    <div class="AddUserTable" style="display: none" id="addForm1">
                        <form method="POST" action="{{ route('register.userAdmin') }}">
                            @csrf
                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">E-Mail</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Full Name">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        <td data-label="User Name">
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username') }}" required
                                                autocomplete="username">
                                        </td>
                                        <td data-label="E-Mail">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email">
                                        </td>
                                        <td data-label="Phone">
                                            <input id="phone" type="text"
                                                class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                value="{{ old('phone') }}" required autocomplete="phone">
                                        </td>
                                        <td data-label="Address">
                                            <input id="address" type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address" value="{{ old('address') }}" required
                                                autocomplete="address">
                                        </td>
                                        <td data-label="Password">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password">
                                        </td>
                                    </tr>
                                    <tr style="align-content: center">
                                        <td>
                                            <button
                                                style="width: 100%; background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                                type="submit" class="btn btn-primary">Create
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <table>
                <caption>Students Table</caption>
                <thead>
                    <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">User Name</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td data-label="Full Name"><a href="{{ route('admin.userDetails', $user) }}">{{$user->name}}</a>
                        </td>
                        <td data-label="User Name">{{$user->username}}</td>
                        <td data-label="E-Mail">{{$user->email}}</a></td>
                        <td data-label="Phone">{{$user->phone}}</a></td>
                        <td data-label="Address">{{$user->address}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="container mt-5">
            <div class="d-flex">
                @if (is_array($users) || is_object($users))
                {{$users->links("pagination::bootstrap-4")}}
                @endif
            </div>
        </div>
    </div>
    <div id="lecturer" style="display:none">
        <h3>CariTau Lecturers: {{$countL}}</h3>
        <div class="users-table">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left my-2">
                        <form method="get" action="{{ route('admin.search') }}" id="myForm">@csrf
                            <div style="display: flex; justify-content: space-between" class="form-group">
                                <input style="margin-right: 5px;" type="text" name="search" class="form-control"
                                    id="search" ariadescribedby="search" placeholder="Search">
                                <button
                                    style="background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                    type="submit" class="btn btn-primary">Find
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="float-right my-2">
                        <a style="background-color: rgb(21, 74, 172); font-weight: 800; color: white;  border:0"
                            class="btn btn-primary" onclick="addUser(2)">Create New Lecturer</a>
                    </div>
                    <div class="AddUserTable" style="display: none" id="addForm2">
                        <div id="alertCourse" style="display: none; text-align: left; margin-top: 60px"
                            class="alert alert-info">
                            <p style="text-align: left;">You can't add new lecturer because all the courses have been
                                taken<br><a href="">Add new
                                    course to assign it to new lecturer</a>
                            </p>
                        </div>
                        <form method="POST" action="{{ route('register.lecturerAdmin') }}">
                            @csrf
                            <table>
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
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        </td>
                                        <td data-label="User Name">
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username') }}" required
                                                autocomplete="username">
                                        </td>
                                        <td data-label="E-Mail">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email">
                                        </td>
                                        <td data-label="Phone">
                                            <input id="phone" type="text"
                                                class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                value="{{ old('phone') }}" required autocomplete="phone">
                                        </td>
                                        <td data-label="Address">
                                            <input id="address" type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address" value="{{ old('address') }}" required
                                                autocomplete="address">
                                        </td>
                                        <td data-label="Password">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password">
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
                </div>
            </div>
            <table>
                <caption>Lecturers Table</caption>
                <thead>
                    <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">User Name</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lecturers as $lecturer)
                    <tr>
                        <td data-label="Full Name"><a
                                href="{{ route('admin.userDetails', $lecturer->ID_user) }}">{{$lecturer->name}}</a>
                        </td>
                        <td data-label="User Name">{{$lecturer->username}}</td>
                        <td data-label="E-Mail">{{$lecturer->email}}</a></td>
                        <td data-label="Phone">{{$lecturer->phone}}</a></td>
                        <td data-label="Address">{{$lecturer->address}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="container mt-5">
            <div class="d-flex">
                @if (is_array($lecturers) || is_object($lecturers))
                {{$lecturers->links("pagination::bootstrap-4")}}
                @endif
            </div>
        </div>
    </div>
    <div id="admin" style="display:none">
        <h3>CariTau Admins: {{$countA}}</h3>
        <div class="users-table">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left my-2">
                        <form method="get" action="{{ route('admin.search') }}" id="myForm">@csrf
                            <div style="display: flex; justify-content: space-between" class="form-group">
                                <input style="margin-right: 5px;" type="text" name="search" class="form-control"
                                    id="search" ariadescribedby="search" placeholder="Search">
                                <button
                                    style="background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                    type="submit" class="btn btn-primary">Find
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="float-right my-2">
                        <a style="background-color: rgb(21, 74, 172); font-weight: 800; color: white;  border:0"
                            class="btn btn-primary" onclick="addUser(3)">Create New Admin</a>
                    </div>
                    <div class="AddUserTable" style="display: none" id="addForm3">
                        <form method="POST" action="{{ route('register.adminAdmin') }}">
                            @csrf
                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">E-Mail</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">Confirm</th>
                                        <th scope="col">Praivte Key</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Full Name">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        </td>
                                        <td data-label="User Name">
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username') }}" required
                                                autocomplete="username">
                                        </td>
                                        <td data-label="E-Mail">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email">
                                        </td>
                                        <td data-label="Phone">
                                            <input id="phone" type="text"
                                                class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                value="{{ old('phone') }}" required autocomplete="phone">
                                        <td data-label="Address">
                                            <input id="address" type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address" value="{{ old('address') }}" required
                                                autocomplete="address">
                                        </td>
                                        <td data-label="Password">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password">
                                        </td>
                                        <td data-label="Private Key">
                                            <input id="privateKey" type="password" class="form-control"
                                                name="privateKey" required autocomplete="new-password">
                                        </td>
                                    </tr>
                                    <tr style="align-content: center">
                                        <td>
                                            <button
                                                style="width: 100%; background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                                type="submit" class="btn btn-primary">Create
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <table>
                <caption>Admins Table</caption>
                <thead>
                    <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">User Name</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                    <tr>
                        <td data-label="Full Name"><a
                                href="{{ route('admin.userDetails', $admin->ID_user) }}">{{$admin->name}}</a></td>
                        <td data-label="User Name">{{$admin->username}}</td>
                        <td data-label="E-Mail">{{$admin->email}}</a></td>
                        <td data-label="Phone">{{$admin->phone}}</a></td>
                        <td data-label="Address">{{$admin->address}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="container mt-5">
            <div class="d-flex">
                @if (is_array($admins) || is_object($admins))
                {{$admins->links("pagination::bootstrap-4")}}
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    function addUser(id) {
    var x = document.getElementById("addForm"+id);
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