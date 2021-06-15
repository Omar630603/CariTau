@extends('layouts.student')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
    <style>
        .display-comment .display-comment {
            margin-left: 40px
        }
    </style>
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
                            {{$m->material_name}} <span data-toggle="tooltip" title="Unlocked"
                                class="fas fa-unlock float-right mt-1">
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{route('material', ['course'=>$course, 'material'=>$m])}}">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span data-toggle="tooltip" title="Unlocked"
                                class="fas fa-unlock float-right mt-1">
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
                            {{$m->material_name}} <span data-toggle="tooltip" title="Unlocked"
                                class="fas fa-unlock float-right mt-1">
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{route('material', ['course'=>$course, 'material'=>$m])}}">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span data-toggle="tooltip" title="Unlocked"
                                class="fas fa-unlock float-right mt-1">
                        </a>
                    </li>
                    @endif
                    @else
                    @if ($m->ID_material == $material->ID_material)
                    <li class="active">
                        <a href="">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span data-toggle="tooltip" title="locked"
                                class="fas fa-lock float-right mt-1">
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span data-toggle="tooltip" title="locked"
                                class="fas fa-lock float-right mt-1">
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
                            {{$m->material_name}} <span data-toggle="tooltip" title="locked"
                                class="fas fa-lock float-right mt-1">
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="">
                            <span class="fas fa-book-open mr-3"></span>
                            {{$m->material_name}} <span data-toggle="tooltip" title="locked"
                                class="fas fa-lock float-right mt-1">
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
                <div class="container">
                    <div>
                        @if ($message = Session::get('fail'))
                        <div class="alert alert-warning">
                            <p>{{ $message }}</p>
                        </div>
                        @elseif ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="row" style="padding: 30px">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    This is Forum for <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}">{{$material->material_name}}</a> Material
                                </div>
                                <div class="card-body">
                                    <p><b>{{ $forum->title }}</b></p>
                                    <p>
                                        {{ $forum->body }}
                                    </p>
                                    <hr />
                                    <h4>Display Comments</h4>
                                    @include('user.partials._comment_replies', ['comment' => $forum->comment, 'ID_forum' =>
                                    $forum->ID_forum])
                                    <hr />
                                    <h4>Add comment</h4>
                                    <form method="post" action="{{ route('user.addForumComment') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="comment_body" class="form-control" />
                                            <input type="hidden" name="post_id" value="{{ $forum->ID_forum }}" />
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-dark" value="Add Comment" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($enrollment->status == 0)
                @if ($material->order == 1)
                <div class="container">
                    <div>
                        @if ($message = Session::get('fail'))
                        <div class="alert alert-warning">
                            <p>{{ $message }}</p>
                        </div>
                        @elseif ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="row" style="padding: 30px">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    This is Forum for <a
                                        href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}">{{$material->material_name}}</a>
                                    Material
                                </div>
                                <div class="card-body">
                                    <p><b>{{ $forum->title }}</b></p>
                                    <p>
                                        {{ $forum->body }}
                                    </p>
                                    <hr />
                                    <h4>Display Comments</h4>
                                    @include('user.partials._comment_replies', ['comment' => $forum->comment, 'ID_forum' =>
                                    $forum->ID_forum])
                                    <hr />
                                    <h4>Add comment</h4>
                                    <form method="post" action="{{ route('user.addForumComment') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="comment_body" class="form-control" />
                                            <input type="hidden" name="post_id" value="{{ $forum->ID_forum }}" />
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-dark" value="Add Comment" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="container justify-content-center">
                    <h3 class="alert alert-danger" style="margin: 40px; ">
                        <center>You dont have access you need to pay first :( <i class="fa fa-ban" aria-hidden="true"></i></center>
                    </h3>
                </div>
                @endif
            @endif
        @else
        <div class="container justify-content-center">
            <h3 class="alert alert-info" style="margin: 40px; ">
                <center>You dont have access you need to enroll first :( <i class="fa fa-ban" aria-hidden="true"></i></center>
            </h3>
        </div>
        @endif
        <!-- Page Content  -->

    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
@endsection