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
    <div class="users-table" id="student">
        <h2>Students Matching Search Results</h2>
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
                @foreach ($searchResults as $user)
                @if (!in_array($user->ID_user, $adminLecturers))
                <tr>
                    <td data-label="Full Name"><a href="{{ route('admin.userDetails', $user) }}">{{$user->name}}</a>
                    </td>
                    <td data-label="User Name">{{$user->username}}</td>
                    <td data-label="E-Mail">{{$user->email}}</a></td>
                    <td data-label="Phone">{{$user->phone}}</a></td>
                    <td data-label="Address">{{$user->address}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="users-table" id="lecturer" style="display:none">
        <h2>Lecturers Matching Search Results</h2>
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
                @foreach ($searchResults as $user)
                @if (in_array($user->ID_user, $lecturers))
                <tr>
                    <td data-label="Full Name"><a href="{{ route('admin.userDetails', $user) }}">{{$user->name}}</a>
                    </td>
                    <td data-label="User Name">{{$user->username}}</td>
                    <td data-label="E-Mail">{{$user->email}}</a></td>
                    <td data-label="Phone">{{$user->phone}}</a></td>
                    <td data-label="Address">{{$user->address}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="users-table" id="admin" style="display:none">
        <h2>Admins Matching Search Results</h2>
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
                @foreach ($searchResults as $user)
                @if (in_array($user->ID_user, $admins))
                <tr>
                    <td data-label="Full Name"><a href="{{ route('admin.userDetails', $user) }}">{{$user->name}}</a>
                    </td>
                    <td data-label="User Name">{{$user->username}}</td>
                    <td data-label="E-Mail">{{$user->email}}</a></td>
                    <td data-label="Phone">{{$user->phone}}</a></td>
                    <td data-label="Address">{{$user->address}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection