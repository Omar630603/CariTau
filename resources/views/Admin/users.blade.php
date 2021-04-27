@extends('layouts.adminApp')

@section('content')
<div class="container">
    <div class="users-table">
        <h3>CariTau Users: {{count($users)}}</h3>
        <table>
            <caption>Users Table</caption>
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
                    <td data-label="FullName"><a href="">{{$user->name}}</a></td>
                    <td data-label="UserName">{{$user->username}}</td>
                    <td data-label="E-Mail">{{$user->email}}</a></td>
                    <td data-label="Phone">{{$user->phone}}</a></td>
                    <td data-label="Address">{{$user->address}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="container">
    <div class="container mt-5">
        <div class="d-flex">
            @if (is_array($users) || is_object($users))
            {{$users->links("pagination::bootstrap-4")}}
            @endif
        </div>
    </div>
</div>
@endsection