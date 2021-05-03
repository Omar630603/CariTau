@extends('layouts.adminApp')
@section('content')
@if (!in_array($user->ID_user, $adminLecturers))
<h2>Student</h2>
<tr>
    <td data-label="Full Name">{{$userCourse}}</td>
    <td data-label="Full Name">{{$user->name}}</td>
    <td data-label="User Name">{{$user->username}}</td>
    <td data-label="E-Mail">{{$user->email}}</a></td>
    <td data-label="Phone">{{$user->phone}}</a></td>
    <td data-label="Address">{{$user->address}}</td>
</tr>
@elseif(in_array($user->ID_user, $lecturers))
<h2>Lecturer</h2>
<tr>
    <td data-label="Full Name">{{$lecturerCourse}}</td><br>
    <td data-label="Full Name">{{$user->name}}</td>
    <td data-label="User Name">{{$user->username}}</td>
    <td data-label="E-Mail">{{$user->email}}</a></td>
    <td data-label="Phone">{{$user->phone}}</a></td>
    <td data-label="Address">{{$user->address}}</td>
</tr>
@elseif(in_array($user->ID_user, $admins))
<h2>Admin</h2>
<tr>
    <td data-label="Full Name">{{$user->name}}</td>
    <td data-label="User Name">{{$user->username}}</td>
    <td data-label="E-Mail">{{$user->email}}</a></td>
    <td data-label="Phone">{{$user->phone}}</a></td>
    <td data-label="Address">{{$user->address}}</td>
</tr>
@endif
@endsection