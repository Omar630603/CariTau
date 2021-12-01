@extends('layouts.student')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">User : {{ Auth::user()->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Courses</li>
        </ol>
    </nav>
    <h6 class="d-flex align-items-center mb-3" style="background-color: #e9ecef;padding:10px;"><i
            class="material-icons text-info mr-2"></i>Course List: here are all the courses
        that you have enrolled,
        {{ Auth::user()->name }}!
    </h6>
    <h6><i>Amount : <strong> {{ count($userCourse) }} </strong>,</i></h6>
</div>
<section class="wrapper">
    <div class="container-fostrap">
        <div class="content">
            <div class="container">
                <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-between">
                    @if (count($userCourse) > 0)
                    @foreach ($userCourse as $course)
                    <div class="card" style="width: 15rem;">
                        <img class="card-img-top" src="{{ asset('storage/' . $course->image) }}" />
                        <div class="card-content card-body d-flex flex-column">
                            <h4 class="card-title" style="display: flex; justify-content: space-between">
                                <div style="width: 145px; margin-right:-10px">
                                    <a href="">{{ $course->course_name }}</a>
                                </div>
                                <div style="width: 80px; margin-left:-10px">
                                    @if ($course->pivot->status)
                                    <p style="text-align: center;" class="btn-sm btn-success">
                                        Full Access
                                    </p>
                                    @else
                                    <p style="text-align: center;" class="btn-sm btn-dark">
                                        Preview</p>
                                    @endif
                                </div>
                            </h4>
                            <div class="mt-auto card-read-more" style="margin-top: 40px;>">
                                <a href="{{route('course', $course)}}" class="mt-auto btn btn-link btn-block">
                                    Study!
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="container">
                        <div class="justify-content-center">
                            <h5 class="card-title">There are no courses yet that you have enrroled :( click
                                <a style="color: blue" href="{{ route('courses') }}">here</a> to see all the
                                courses in CariTau! :)
                            </h5>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection