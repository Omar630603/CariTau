@extends('layouts.adminApp')
@section('content')
<div class="container">
    <h3 style="margin: 20px">Lecturers in CariTau: {{count($lecturers)}}</h3>
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
@endsection