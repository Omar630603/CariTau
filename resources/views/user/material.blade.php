@extends('layouts.student')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
</head>

<body>
    <div class="wrapper d-flex align-items-stretch"
        style="margin-top: -1.5rem !important;margin-bottom: -1.5rem !important;">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary shadow-none">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div class="p-4">
                <h1>
                    <a href="{{ route('course', $course) }}" style="text-decoration: none; margin-top:10px"
                        class="logo">{{$course->course_name}}
                        <span>{{$course->description}}
                        </span>
                    </a>
                </h1>
                <ul class="list-unstyled components mb-5">
                    @foreach ($materials as $m)
                    @if (is_array($enrollment) || is_object($enrollment))
                    @if ($enrollment->status == 1)
                    @if ($m->ID_material == $material->ID_material)
                    <li class="active">
                        <a href="{{route('material', ['course'=>$course, 'material'=>$m])}}">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span style="font-size: 20px" data-toggle="tooltip" title="Unlocked"
                                class="fa fa-unlock float-right mt-1">
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{route('material', ['course'=>$course, 'material'=>$m])}}">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span style="font-size: 20px" data-toggle="tooltip" title="Unlocked"
                                class="fa fa-unlock float-right mt-1">
                        </a>

                    </li>
                    @endif
                    @elseif($enrollment->status == 0)
                    @if ($m->order == 1)
                    @if ($m->ID_material == $material->ID_material)
                    <li class="active">
                        <a href="{{route('material', ['course'=>$course, 'material'=>$m])}}">
                            <span class="fas fa-book-open mr-3">
                            </span>
                            {{$m->material_name}} <span style="font-size: 20px" data-toggle="tooltip" title="Unlocked"
                                class="fa fa-unlock float-right mt-1">
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{route('material', ['course'=>$course, 'material'=>$m])}}">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span style="font-size: 20px" data-toggle="tooltip" title="Unlocked"
                                class="fa fa-unlock float-right mt-1">
                        </a>
                    </li>
                    @endif
                    @else
                    @if ($m->ID_material == $material->ID_material)
                    <li class="active">
                        <a href="">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span style="font-size: 22.5px" data-toggle="tooltip" title="locked"
                                class="fa fa-lock float-right mt-1">
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span style="font-size: 22.5px" data-toggle="tooltip" title="locked"
                                class="fa fa-lock float-right mt-1">
                        </a>
                    </li>
                    @endif
                    @endif
                    @endif
                    @else
                    @if ($m->ID_material == $material->ID_material)
                    <li class="active">
                        <a href="">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span style="font-size: 22.5px" data-toggle="tooltip" title="locked"
                                class="fa fa-lock float-right mt-1">
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span style="font-size: 22.5px" data-toggle="tooltip" title="locked"
                                class="fa fa-lock float-right mt-1">
                        </a>
                    </li>
                    @endif
                    @endif
                    @endforeach
                </ul>
            </div>
        </nav>

        @if (is_array($enrollment) || is_object($enrollment))
        @if ($enrollment->status == 1)
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="row gutters-sm" id="info" style="margin-left: 20px;max-width: none">
                <div class="col-md-4 mb-3" style="max-width: none">
                    <div class="card h-100" style="border-radius:20px;">
                        <div class="card-body" style="background: #3ba7ff;border-radius:20px;">
                            <div class="d-flex flex-column align-items-center text-center">
                                <a href="{{ route('user.profile') }}"><img
                                        src="{{ asset('storage/' . Auth::user()->image) }}"
                                        alt="user{{ Auth::user()->username }}" class="rounded-circle" width="150"
                                        style="border: white 2px solid;"></a>
                                <div class="mt-3">
                                    <h6 style="color: white; text-transform: uppercase">{{ Auth::user()->username }}
                                    </h6>
                                    <p style="color: white">Student</p>
                                    <p style="color: white">{{ Auth::user()->address }} - {{ Auth::user()->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-3">
                    <div class="card h-100" style="border-radius:20px;">
                        <div class="card-body d-flex flex-column"
                            style="text-align: center;border-radius:20px; background:linear-gradient(rgba(0, 0, 0, 0.6),rgba(0, 0, 0, 0.6)), url({{ asset('storage/' . $material->image) }});background-position: center;">
                            <h6 class="d-flex align-items-center mb-3"
                                style="text-align: left;border-radius:20px; background-color: #e9ecef;padding:10px;">
                                <i class="material-icons text-info mr-2"></i>{{ $material->material_name }}
                            </h6>
                            <h5 style="color: #fff;">
                                {{ $material->description }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3" style="padding-left: 35px;padding-right: 0;max-width: none">
                <div class="card h-100" style="border-radius:20px;">
                    <div class="card-body">
                        <h6 class="d-flex materialsListHeader">
                            <i class="material-icons text-info mr-2"></i>Content List: in {{$material->material_name}}
                        </h6>
                        <div class="row" style="justify-content: space-evenly;">
                            <div
                                style="display: flex; flex-direction: column; justify-content: space-between; width: 100%">
                                <div class="container" id="files">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: column; justify-content: space-between">
                                            @if(count($files)>0)
                                            <strong style="margin-bottom: 5px; margin-right: 5px; color: #3b4ec6">#
                                                Files</strong>
                                            @foreach ($files as $file)
                                            <div class="mt-auto"
                                                style="display: flex; gap: 5px; padding-bottom: 5px; flex-wrap: wrap">
                                                <img style="margin-top: 5px; flex:0" width="30px" height="30px"
                                                    src="{{ asset('storage/'.$file->icon) }}" alt="">
                                                @if ($file->file_extension === 'pdf' || $file->file_extension ===
                                                'jpeg'||
                                                $file->file_extension === 'png'|| $file->file_extension === 'jpg')
                                                <a style="margin-top: 10px; flex:1"
                                                    href="{{route('user.showFile', $file)}}" target="_blank"
                                                    rel="noopener noreferrer">{{$file->file_title}}</a>
                                                @else
                                                <a style="margin-top: 10px; flex:1"
                                                    href="{{route('user.downloadFiles', $file)}}">{{$file->file_title}}</a>
                                                @endif
                                                <a style="margin-right: 5px; margin-top: 15px; flex:0"
                                                    class="float-right" href="{{route('user.downloadFiles', $file)}}"><i
                                                        class="fas fa-download"></i></a>
                                            </div>
                                            <span
                                                style="margin-top: 5px;margin-bottom: 5px;border-bottom: 1px solid #ccc;">
                                                <h6 class="d-flex align-items-center"
                                                    style="padding:15px; border-radius:20px;color:#000; background-color: #ced6fc;">
                                                    {{$file->description}}
                                                </h6>
                                            </span>
                                            @endforeach
                                            @else
                                            {{ __('No files yet!') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="videos">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: column; justify-content: space-between">
                                            @if(count($videos)>0)
                                            <strong style="margin-bottom: 5px; margin-right: 5px; color: #3b4ec6">#
                                                Videos</strong>
                                            @foreach ($videos as $video)
                                            <div class="mt-auto"
                                                style="display: flex; gap: 15px; padding-bottom: 5px; flex-wrap: wrap">
                                                <img style="margin-top: 5px;" width="30px" height="30px"
                                                    src="{{ asset('storage/images/video.png') }}" alt="">
                                                <a style="margin-top: 10px;" href="{{$video->video_url}}"
                                                    target="_blank" rel="noopener noreferrer">{{$video->video_name}}
                                                </a>
                                            </div>
                                            <span
                                                style="margin-top: 5px;margin-bottom: 5px;border-bottom: 1px solid #ccc;">
                                                <h6 class="d-flex align-items-center"
                                                    style="padding:15px; border-radius:20px;color:#000; background-color: #ced6fc;">
                                                    {{$video->description}}
                                                </h6>
                                            </span>
                                            @endforeach
                                            @else
                                            {{ __('No Video yet') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="quiz">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: column; justify-content: space-between">
                                            @if(count($quizzes)>0)
                                            <strong style="margin-bottom: 5px; margin-right: 5px; color: #3b4ec6">#
                                                Quiz</strong>
                                            @foreach ($quizzes as $quiz)
                                            <div class="mt-auto"
                                                style="display: flex; gap: 15px; padding-bottom: 5px; flex-wrap: wrap">
                                                <img style="margin-top: 5px;" width="30px" height="30px"
                                                    src="{{ asset('storage/images/quiz.png') }}" alt="">
                                                <a style="margin-top: 10px;flex: 1"
                                                    href="{{route('user.showQuiz', ['quiz'=>$quiz, 'course'=>$course,'material'=>$material])}}"
                                                    data-toggle="tooltip" title="Click to access the quiz"
                                                    data-placement="left">
                                                    {{$quiz->quiz_name}}
                                                    @if (!is_array($quiz_user) || is_object($quiz_user))
                                                    -> ({{count($questions)}}/5 Questions)
                                                    @endif
                                                </a>
                                                @if (is_array($quiz_user) || is_object($quiz_user))
                                                <div class="alert alert-success" style="text-align: center; flex:1">
                                                    You Have Already Taken This Quiz <br>
                                                    <strong>Your Score {{$quiz_user->score}} <i class="fa fa-percent"
                                                            aria-hidden="true"></i></strong>
                                                </div>
                                                @else
                                                <div class="alert alert-info" style="text-align: center; flex:1">
                                                    This Quiz Containes <br>
                                                    <strong>({{count($questions)}}/5 Questions) ? <i
                                                            class="fa fa-percent" aria-hidden="true"></i></strong>
                                                </div>
                                                @endif
                                            </div>
                                            <span
                                                style="margin-top: 5px;margin-bottom: 5px;border-bottom: 1px solid #ccc;">
                                                <h6 class="d-flex align-items-center"
                                                    style="padding:15px; border-radius:20px;color:#000; background-color: #ced6fc;">
                                                    {{$quiz->description}}
                                                </h6>
                                            </span>
                                            @endforeach
                                            @else
                                            {{ __('No quiz yet') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="fourms">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: column; justify-content: space-between">
                                            @if(count($forums)>0)
                                            <strong style="margin-bottom: 5px; margin-right: 5px; color: #3b4ec6">#
                                                Fourms of Discussion</strong>
                                            @foreach ($forums as $forum)
                                            <div class="mt-auto"
                                                style="display: flex; gap: 15px; padding-bottom: 5px; flex-wrap: wrap">
                                                <img style="margin-top: 5px;" width="30px" height="30px"
                                                    src="{{ asset('storage/images/forum.png') }}" alt="">
                                                <a style="margin-top: 10px;"
                                                    href="{{route('user.showForum', ['forum'=> $forum, 'course'=>$course, 'material'=> $material])}}"
                                                    target="_blank" rel="noopener noreferrer" data-toggle="tooltip"
                                                    title="Click to view Forum">{{$forum->title}}
                                                </a>
                                            </div>
                                            <span
                                                style="margin-top: 5px;margin-bottom: 5px;border-bottom: 1px solid #ccc;">
                                                <h6 class="d-flex align-items-center"
                                                    style="padding:15px; border-radius:20px;color:#000; background-color: #ced6fc;">
                                                    {{$forum->body}}
                                                </h6>
                                            </span>
                                            @endforeach
                                            @else
                                            {{ __('No forum yet') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($enrollment->status == 0)
        @if ($material->order == 1)
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="row gutters-sm" id="info" style="margin-left: 20px;max-width: none">
                <div class="col-md-4 mb-3" style="max-width: none">
                    <div class="card h-100" style="border-radius:20px;">
                        <div class="card-body" style="background: #3ba7ff;border-radius:20px;">
                            <div class="d-flex flex-column align-items-center text-center">
                                <a href="{{ route('user.profile') }}"><img
                                        src="{{ asset('storage/' . Auth::user()->image) }}"
                                        alt="user{{ Auth::user()->username }}" class="rounded-circle" width="150"
                                        style="border: white 2px solid;"></a>
                                <div class="mt-3">
                                    <h6 style="color: white; text-transform: uppercase">{{ Auth::user()->username }}
                                    </h6>
                                    <p style="color: white">Student</p>
                                    <p style="color: white">{{ Auth::user()->address }} - {{ Auth::user()->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-3">
                    <div class="card h-100" style="border-radius:20px;">
                        <div class="card-body d-flex flex-column"
                            style="text-align: center;border-radius:20px; background:linear-gradient(rgba(0, 0, 0, 0.6),rgba(0, 0, 0, 0.6)), url({{ asset('storage/' . $material->image) }});background-position: center;">
                            <h6 class="d-flex align-items-center mb-3"
                                style="text-align: left;border-radius:20px; background-color: #e9ecef;padding:10px;">
                                <i class="material-icons text-info mr-2"></i>{{ $material->material_name }}
                            </h6>
                            <h5 style="color: #fff;">
                                {{ $material->description }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3" style="padding-left: 35px;padding-right: 0;max-width: none">
                <div class="card h-100" style="border-radius:20px;">
                    <div class="card-body">
                        <h6 class="d-flex materialsListHeader">
                            <i class="material-icons text-info mr-2"></i>Content List: in {{$material->material_name}}
                        </h6>
                        <div class="row" style="justify-content: space-evenly;">
                            <div
                                style="display: flex; flex-direction: column; justify-content: space-between; width: 100%">
                                <div class="container" id="files">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: column; justify-content: space-between">
                                            @if(count($files)>0)
                                            <strong style="margin-bottom: 5px; margin-right: 5px; color: #3b4ec6">#
                                                Files</strong>
                                            @foreach ($files as $file)
                                            <div class="mt-auto"
                                                style="display: flex; gap: 5px; padding-bottom: 5px; flex-wrap: wrap">
                                                <img style="margin-top: 5px; flex:0" width="30px" height="30px"
                                                    src="{{ asset('storage/'.$file->icon) }}" alt="">
                                                @if ($file->file_extension === 'pdf' || $file->file_extension ===
                                                'jpeg'||
                                                $file->file_extension === 'png'|| $file->file_extension === 'jpg')
                                                <a style="margin-top: 10px; flex:1"
                                                    href="{{route('user.showFile', $file)}}" target="_blank"
                                                    rel="noopener noreferrer">{{$file->file_title}}</a>
                                                @else
                                                <a style="margin-top: 10px; flex:1"
                                                    href="{{route('user.downloadFiles', $file)}}">{{$file->file_title}}</a>
                                                @endif
                                                <a style="margin-right: 5px; margin-top: 15px; flex:0"
                                                    class="float-right" href="{{route('user.downloadFiles', $file)}}"><i
                                                        class="fas fa-download"></i></a>
                                            </div>
                                            <span
                                                style="margin-top: 5px;margin-bottom: 5px;border-bottom: 1px solid #ccc;">
                                                <h6 class="d-flex align-items-center"
                                                    style="padding:15px; border-radius:20px;color:#000; background-color: #ced6fc;">
                                                    {{$file->description}}
                                                </h6>
                                            </span>
                                            @endforeach
                                            @else
                                            {{ __('No files yet!') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="videos">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: column; justify-content: space-between">
                                            @if(count($videos)>0)
                                            <strong style="margin-bottom: 5px; margin-right: 5px; color: #3b4ec6">#
                                                Videos</strong>
                                            @foreach ($videos as $video)
                                            <div class="mt-auto"
                                                style="display: flex; gap: 15px; padding-bottom: 5px; flex-wrap: wrap">
                                                <img style="margin-top: 5px;" width="30px" height="30px"
                                                    src="{{ asset('storage/images/video.png') }}" alt="">
                                                <a style="margin-top: 10px;" href="{{$video->video_url}}"
                                                    target="_blank" rel="noopener noreferrer">{{$video->video_name}}
                                                </a>
                                            </div>
                                            <span
                                                style="margin-top: 5px;margin-bottom: 5px;border-bottom: 1px solid #ccc;">
                                                <h6 class="d-flex align-items-center"
                                                    style="padding:15px; border-radius:20px;color:#000; background-color: #ced6fc;">
                                                    {{$video->description}}
                                                </h6>
                                            </span>
                                            @endforeach
                                            @else
                                            {{ __('No Video yet') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="quiz">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: column; justify-content: space-between">
                                            @if(count($quizzes)>0)
                                            <strong style="margin-bottom: 5px; margin-right: 5px; color: #3b4ec6">#
                                                Quiz</strong>
                                            @foreach ($quizzes as $quiz)
                                            <div class="mt-auto"
                                                style="display: flex; gap: 15px; padding-bottom: 5px; flex-wrap: wrap">
                                                <img style="margin-top: 5px;flex: 0" width="30px" height="30px"
                                                    src="{{ asset('storage/images/quiz.png') }}" alt="">
                                                <a style="margin-top: 10px;flex: 1"
                                                    href="{{route('user.showQuiz', ['quiz'=>$quiz, 'course'=>$course,'material'=>$material])}}"
                                                    data-toggle="tooltip" title="Click to access the quiz"
                                                    data-placement="left">{{$quiz->quiz_name}}
                                                    @if (!is_array($quiz_user) || is_object($quiz_user))
                                                    -> ({{count($questions)}}/5 Questions)
                                                    @endif
                                                </a>
                                                @if (is_array($quiz_user) || is_object($quiz_user))
                                                <div class="alert alert-success" style="text-align: center; flex:1">
                                                    You Have Already Taken This Quiz <br>
                                                    <strong>Your Score {{$quiz_user->score}} <i class="fa fa-percent"
                                                            aria-hidden="true"></i></strong>
                                                </div>
                                                @else
                                                <div class="alert alert-info" style="text-align: center; flex:1">
                                                    This Quiz Containes <br>
                                                    <strong>({{count($questions)}}/5 Questions) ? <i
                                                            class="fa fa-percent" aria-hidden="true"></i></strong>
                                                </div>
                                                @endif
                                            </div>
                                            <span
                                                style="margin-top: 5px;margin-bottom: 5px;border-bottom: 1px solid #ccc;">
                                                <h6 class="d-flex align-items-center"
                                                    style="padding:15px; border-radius:20px;color:#000; background-color: #ced6fc;">
                                                    {{$quiz->description}}
                                                </h6>
                                            </span>
                                            @endforeach
                                            @else
                                            {{ __('No quiz yet') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="fourms">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: column; justify-content: space-between">
                                            @if(count($forums)>0)
                                            <strong style="margin-bottom: 5px; margin-right: 5px; color: #3b4ec6">#
                                                Fourms of
                                                Discussion</strong>
                                            @foreach ($forums as $forum)
                                            <div class="mt-auto"
                                                style="display: flex; gap: 15px; padding-bottom: 5px; flex-wrap: wrap">
                                                <img style="margin-top: 5px;" width="30px" height="30px"
                                                    src="{{ asset('storage/images/forum.png') }}" alt="">
                                                <a style="margin-top: 10px;"
                                                    href="{{route('user.showForum', ['forum'=> $forum, 'course'=>$course, 'material'=> $material])}}"
                                                    target="_blank" rel="noopener noreferrer" data-toggle="tooltip"
                                                    title="Click to view Forum">{{$forum->title}}
                                                </a>
                                            </div>
                                            <span
                                                style="margin-top: 5px;margin-bottom: 5px;border-bottom: 1px solid #ccc;">
                                                <h6 class="d-flex align-items-center"
                                                    style="padding:15px; border-radius:20px;color:#000; background-color: #ced6fc;">
                                                    {{$forum->body}}
                                                </h6>
                                            </span>
                                            @endforeach
                                            @else
                                            {{ __('No forum yet') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="container justify-content-center">
            <h3 class="alert alert-danger" style="margin: 40px; ">
                <center>You dont have access you need to pay first :( <i class="fa fa-ban" aria-hidden="true"></i>
                </center>
            </h3>
        </div>
        @endif
        @endif
        @else
        <div class="container justify-content-center">
            <h3 class="alert alert-info" style="margin: 40px; ">
                <center>You dont have access you need to enroll first :( <i class="fa fa-ban" aria-hidden="true"></i>
                </center>
            </h3>
        </div>
        @endif
        <!-- Page Content  -->

    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
@endsection