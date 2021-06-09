@extends('layouts.welcome')
@section('content')
<div class="container">
    <div class="bg-light" style="margin-top: -40px">
        <div class="container py-5">
            <div class="row h-100 align-items-center py-5" style="margin-top: -10px">
                <h1 class="display-4">About Our Lecturers</h1>
                <div style="display: flex; justify-content: space-between; gap: 10px">
                    <p class="lead text-muted mb-0">On this page, there is a display of lecturers who collaborate with
                        CariTau. The lecturers we chose are lecturers who are competent in their fields and willing to
                        give
                        their best for this platform. The lecturers who work with us are fresh graduate students who are
                        expected to provide knowledge that is still fresh and new yet very beneficial for your
                        educational
                        needs.
                    </p>
                    <img src="{{ asset('storage/images/Lecturers.svg') }}" width="300px" height="300px" alt="Image"
                        class="img-fluid float-right" style="margin-top: -50px">
                </div>
            </div>
            <div class="row h-100 align-items-center py-5" style="margin: -50px 0">
                <h1>Lecturers in CariTau: {{count($lecturers)}}</h1>
            </div>
        </div>
    </div>

    <div class="main center">
        @foreach ($lecturers as $lecturer)
        <div class="boxLectuter center">
            <a href="">
                <img src="{{asset('storage/'.$lecturer->image)}}" alt="">
            </a>
            <div>
                <p class="user_name">{{$lecturer->name}}</p>
                @foreach ($courses as $course)
                @if ($lecturer->ID_course == $course->ID_course)
                <a style="text-decoration: none; text-align: center" href="">
                    <p class="skill">{{$course->course_name}}</p>
                </a>
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
                    <div class="justify-content-center">
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a href="#" class="social-link card-social"><i
                                        class="fa fa-facebook-f card-social-icon"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link card-social"><i
                                        class="fa fa-twitter card-social-icon"></i></a>
                            </li>
                            <li class="list-inline-item"><a href="#" class="social-link card-social"><i
                                        class="fa fa-instagram card-social-icon"></i></a>
                            </li>
                            <li class="list-inline-item"><a href="#" class="social-link card-social"><i
                                        class="card-social-icon fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
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