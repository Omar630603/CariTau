@extends('layouts.student')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">User : {{ Auth::user()->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <div class="dashboard">
            <div class="container" style="padding: 0">
                <div class="col-md-4 mb-3" style="max-width: none">
                    <div class="card" style="border-radius:20px;">
                        <div class="card-body" style="background: #3ba7ff;border-radius:20px;">
                            <div class="d-flex flex-column align-items-center text-center">
                                <a href="{{ route('user.profile') }}">
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                        alt="user{{ Auth::user()->username }}" class="rounded-circle" width="150"
                                        style="border: white 2px solid;"></a>
                                <div class="mt-3">
                                    <h4 style="color: white">{{ Auth::user()->username }}</h4>
                                    <p style="color: white">Student</p>
                                    <p style="color: white">{{ Auth::user()->address }} - {{ Auth::user()->phone }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" style="padding: 0">
                <div>
                    <div class="col-sm-8 mb-3" style="max-width: none">
                        <div class="card h-100" style="border-radius:20px;">
                            <div class="card-body">
                                <h6 class="d-flex align-items-center mb-3" style="background-color: #e9ecef;padding:10px;">
                                    <i class="material-icons text-info mr-2"></i>Course Progress
                                </h6>
                                @if (count($userCourse) > 0)
                                    @foreach ($userCourse as $course)
                                        <small>{{ $course->course_name }}</small>
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 80%"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="container">
                                        <div class="justify-content-center">
                                            <h5 class="card-title">There are no courses yet that you have enrroled :(
                                                Therefore
                                                no progress. click
                                                <a style="color: blue" href="{{ route('courses') }}">here</a> to see all
                                                the
                                                courses in CariTau! :)
                                            </h5>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="col-sm-8 mb-3" style="max-width: none">
                        <div class="card h-100" style="border-radius:20px;">
                            <div class="card-body">
                                <h6 class="d-flex align-items-center mb-3" style="background-color: #e9ecef;padding:10px;">
                                    <i class="material-icons text-info mr-2"></i>Course List
                                </h6>
                                @if (count($userCourse) > 0)
                                    @foreach ($userCourse as $course)
                                        <a href="" style="text-decoration: none">
                                            <p style="margin: 1px; border-bottom: 1px solid #ccc; padding: 5px">
                                                {{ $course->course_name }}</p>
                                        </a>
                                        @if ($course->pivot->status)
                                            <p style="width: 80px; text-align: center; float: right; margin-top: -30px; margin-right:5px"
                                                class="btn-sm btn-success">
                                                Full Access
                                            </p>
                                        @else
                                            <p style="width: 80px; text-align: center; float: right; margin-top: -30px; margin-right:5px"
                                                class="btn-sm btn-dark">Preview</p>
                                        @endif
                                        <br>
                                    @endforeach
                                @else
                                    <div class="container">
                                        <div class="justify-content-center">
                                            <h5 class="card-title">There are no courses yet that you have enrroled :( click
                                                <a style="color: blue" href="{{ route('courses') }}">here</a> to see all
                                                the
                                                courses in CariTau! :)
                                            </h5>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
