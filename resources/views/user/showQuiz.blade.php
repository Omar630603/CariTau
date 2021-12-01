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
                            This is Quiz for <a
                                href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}">{{$material->material_name}}</a>
                            Material
                        </div>
                        <div class="card-body">
                            <div style="display: flex;gap:10px; flex-wrap: wrap; margin-bottom: -10px;">
                                <p><b>{{ $quiz->quiz_name }} :-</b></p>
                                <p>
                                    {{ $quiz->description }}
                                </p>
                            </div>
                            <div>
                                @if (is_array($quiz_user) || is_object($quiz_user))
                                <div class="alert alert-success" style="text-align: center">
                                    You Have Already Taken This Quiz <br>
                                    <strong>Your Score {{$quiz_user->score}}<i class="fa fa-percent"
                                            aria-hidden="true"></i></strong>
                                </div>
                                @else
                                @if (count($questions)>0)
                                @php
                                $no = 0;
                                @endphp
                                <form action="{{route('user.doQuiz', $quiz)}}" method="POST">
                                    @csrf
                                    @foreach ($questions as $question)
                                    @php $no++; @endphp
                                    <div style="border-bottom: 1px solid #ccc; padding: 20px">
                                        <h6>
                                            <strong># {{$no}} </strong>{{$question->question}}<br>
                                        </h6>
                                        <input type="checkbox" id="option_one{{$question->ID_question}}"
                                            name="answer{{$question->ID_question}}" value="{{$question->option_one}}">
                                        <label for="option_one{{$question->ID_question}}">
                                            {{$question->option_one}}</label><br>

                                        <input type="checkbox" id="option_two{{$question->ID_question}}"
                                            name="answer{{$question->ID_question}}" value="{{$question->option_two}}">
                                        <label for="option_two{{$question->ID_question}}">
                                            {{$question->option_two}}</label><br>

                                        <input type="checkbox" id="option_three{{$question->ID_question}}"
                                            name="answer{{$question->ID_question}}" value="{{$question->option_three}}">
                                        <label for="option_three{{$question->ID_question}}">
                                            {{$question->option_three}}</label><br>

                                        <input type="checkbox" id="option_four{{$question->ID_question}}"
                                            name="answer{{$question->ID_question}}" value="{{$question->option_four}}">
                                        <label for="option_four{{$question->ID_question}}">
                                            {{$question->option_four}}</label><br>
                                    </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-outline-dark mt-2 float-right">Send</button>
                                </form>
                                @else
                                No questions yet :(
                                @endif
                                @endif
                            </div>
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
                            This is Quiz for <a
                                href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}">{{$material->material_name}}</a>
                            Material
                        </div>
                        <div class="card-body">
                            <div style="display: flex;gap:10px; flex-wrap: wrap; margin-bottom: -10px;">
                                <p><b>{{ $quiz->quiz_name }} :-</b></p>
                                <p>
                                    {{ $quiz->description }}
                                </p>
                            </div>
                            <div>
                                @if (is_array($quiz_user) || is_object($quiz_user))
                                <div class="alert alert-success" style="text-align: center">
                                    You Have Already Taken This Quiz <br>
                                    <strong>Your Score {{$quiz_user->score}}<i class="fa fa-percent"
                                            aria-hidden="true"></i></strong>
                                </div>
                                @else
                                @if (count($questions)>0)
                                @php
                                $no = 0;
                                @endphp
                                <form action="{{route('user.doQuiz', $quiz)}}" method="POST">
                                    @csrf
                                    @foreach ($questions as $question)
                                    @php $no++; @endphp
                                    <div style="border-bottom: 1px solid #ccc; padding: 20px">
                                        <h6>
                                            <strong># {{$no}} </strong>{{$question->question}}<br>
                                        </h6>
                                        <input type="checkbox" id="option_one{{$question->ID_question}}"
                                            name="answer{{$question->ID_question}}" value="{{$question->option_one}}">
                                        <label for="option_one{{$question->ID_question}}">
                                            {{$question->option_one}}</label><br>

                                        <input type="checkbox" id="option_two{{$question->ID_question}}"
                                            name="answer{{$question->ID_question}}" value="{{$question->option_two}}">
                                        <label for="option_two{{$question->ID_question}}">
                                            {{$question->option_two}}</label><br>

                                        <input type="checkbox" id="option_three{{$question->ID_question}}"
                                            name="answer{{$question->ID_question}}" value="{{$question->option_three}}">
                                        <label for="option_three{{$question->ID_question}}">
                                            {{$question->option_three}}</label><br>

                                        <input type="checkbox" id="option_four{{$question->ID_question}}"
                                            name="answer{{$question->ID_question}}" value="{{$question->option_four}}">
                                        <label for="option_four{{$question->ID_question}}">
                                            {{$question->option_four}}</label><br>
                                    </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-outline-dark mt-2 float-right">Send</button>
                                </form>
                                @else
                                No questions yet :(
                                @endif
                                @endif
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
<script>
    $('input[type="checkbox"]').on('change', function() {
    $(this).siblings('input[type="checkbox"]').prop('checked', false);
    });
</script>
@endsection