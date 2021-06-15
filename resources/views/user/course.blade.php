@extends('layouts.student')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
</head>

<body>
    <div class="wrapper d-flex align-items-stretch" style="margin-top: -1.5rem !important;margin-bottom: -1.5rem !important;">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary shadow-none">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div class="p-4">
                <h1>
                    <a style="text-decoration: none; margin-top:10px" class="logo">{{$major->major_name}}
                        <span>{{$major->description}}
                        </span>
                    </a>
                </h1>
                <ul class="list-unstyled components mb-5">
                    @foreach ($courses as $c)
                    @if ($c->ID_course == $course->ID_course)
                    <li class="active">
                        <a href="{{route('course', $c)}}"><span class="fas fa-book-open mr-3"></span>{{$c->course_name}}</a>
                    </li>
                    @else
                    <li>
                        <a href="{{route('course', $c)}}"><span class="fas fa-book-open mr-3"></span>{{$c->course_name}}</a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="row gutters-sm" id="info" style="margin-left: 20px;max-width: none">
                <div class="col-md-4 mb-3" style="max-width: none">
                    <div class="card h-100" style="border-radius:20px;">
                        <div class="card-body" style="background: #3ba7ff;border-radius:20px;">
                            <div class="d-flex flex-column align-items-center text-center">
                                <a href="{{ route('user.profile') }}"><img src="{{ asset('storage/' . Auth::user()->image) }}" alt="user{{ Auth::user()->username }}" class="rounded-circle" width="150" style="border: white 2px solid;"></a>
                                <div class="mt-3">
                                    <h6 style="color: white; text-transform: uppercase">{{ Auth::user()->username }}</h6>
                                    <p style="color: white">Student</p>
                                    <p style="color: white">{{ Auth::user()->address }} - {{ Auth::user()->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-3">
                    <div class="card h-100" style="border-radius:20px;">
                        <div class="card-body d-flex flex-column" style="text-align: center;border-radius:20px; background:linear-gradient(rgba(0, 0, 0, 0.6),rgba(0, 0, 0, 0.6)), url({{ asset('storage/' . $course->image) }});background-position: center;">
                            <h6 class="d-flex align-items-center mb-3" style="border-radius:20px; background-color: #e9ecef;padding:10px;">
                                <i class="material-icons text-info mr-2"></i>{{ $course->course_name }}
                            </h6>
                            <h5 style="color: #fff;">
                                {{ $course->description }}
                            </h5>
                            @if (is_array($enrollment) || is_object($enrollment))
                            @if ($enrollment->status == 1)
                            <a disabled style="border-radius:20px;" class="mt-auto btn btn-success">Full Access</a>
                            @elseif($enrollment->status == 0)
                            <div class="mt-auto" style="display: flex; justify-content: space-between; gap:5px">
                                <a data-toggle="tooltip" title="Click to Pay for this Course and Get Full Access" href="" style="border-radius:20px; width: 100%" class="mt-auto btn btn-dark">Preview</a>
                                <span data-toggle="modal" data-target="#unenrolling">
                                    <a data-toggle="tooltip" title="Unenroll in This Course" style="border-radius:20px;width: 100%" class="mt-auto btn btn-danger">Unenroll</a>
                                </span>
                                <div class="modal fade" id="unenrolling" tabindex="-1" role="dialog" aria-labelledby="unenrolling" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">{{$course->course_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-danger" role="alert">
                                                    <h4 class="alert-heading">Unenrolling in Course {{$course->course_name}}</h4>
                                                    You will unenroll in this course it will not be showen in your courses!<br>
                                                    Are you sure?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, I'm not so sure</button>
                                                <a href="{{route('Unenroll', $course)}}" type="button" class="btn btn-danger">Yes, I'm sure</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @else
                            <a data-toggle="modal" data-target="#enrolling" style="border-radius:20px;" class="mt-auto btn btn-outline-success">Enroll</a>
                            <div class="modal fade" id="enrolling" tabindex="-1" role="dialog" aria-labelledby="enrolling" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">{{$course->course_name}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-info" role="alert">
                                                <h4 class="alert-heading">Enrolling in Course {{$course->course_name}}</h4>
                                                You will enroll in this course and will have access to the first material!<br>
                                                Are you in?
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, I'm not so sure</button>
                                            <a href="{{route('enroll', $course)}}" type="button" class="btn btn-success">Yes, I would like to enroll</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3" style="padding-left: 35px;padding-right: 0;max-width: none">
                <div class="card h-100" style="border-radius:20px;">
                    <div class="card-body">
                        <h6 class="d-flex materialsListHeader">
                            <i class="material-icons text-info mr-2"></i>Materials List: in {{$course->course_name}}
                        </h6>
                        <div class="row" style="justify-content: space-evenly">
                            <div style="display: flex; flex-direction: column; justify-content: space-between;width: 100%">
                                @foreach ($materials as $material)
                                <div class="container">
                                    <div class="card">
                                        <div class="card-body d-flex" style="flex-direction: row; justify-content: space-between">
                                            @if (is_array($enrollment) || is_object($enrollment))
                                            @if ($enrollment->status == 1)
                                            <strong style="margin-bottom: 5px; margin-right: 5px">#{{$material->order}}</strong>
                                            <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}" style="text-decoration: none">
                                                <p class="materialName">{{ $material->material_name }}</p>
                                                <span style="color: #44bef1;margin-right: 5px">{{$material->description}}</span>
                                            </a>
                                            <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }} " data-toggle="tooltip" title="Full Access" class="mt-auto btn btn-sm btn-primary">Access</a>
                                            @elseif($enrollment->status == 0)
                                            @if ($material->order == 1)
                                            <strong style="margin-bottom: 5px; margin-right: 5px">#{{$material->order}}</strong>
                                            <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}" data-toggle="tooltip" title="First Material / Free" href="" style="text-decoration: none">
                                                <p class="materialName">{{ $material->material_name }}</p>
                                                <span style="color: #44bef1;margin-right: 5px">{{$material->description}}</span>
                                            </a>
                                            <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}" class="mt-auto btn btn-sm btn-primary">Access</a>
                                            @else
                                            <strong style="margin-bottom: 5px; margin-right: 5px">#{{$material->order}}</strong>
                                            <a data-toggle="tooltip" title="Buy the Course to Access the Rest of the Materials" disabled style="text-decoration: none">
                                                <p class="materialName">{{ $material->material_name }}</p>
                                                <span style="color: #44bef1;margin-right: 5px">{{$material->description}}</span>
                                            </a>
                                            <button disabled class="mt-auto btn btn-sm btn-dark">Deluxe</button>
                                            @endif
                                            @endif
                                            @else
                                            <strong style="margin-bottom: 5px; margin-right: 5px">#{{$material->order}}</strong>
                                            <a data-toggle="tooltip" title="Enroll in the Course to Access the First Material" disabled style="text-decoration: none">
                                                <p class="materialName">{{ $material->material_name }}</p>
                                                <span style="color: #44bef1;margin-right: 5px">{{$material->description}}</span>
                                            </a>
                                            <button disabled class="mt-auto btn btn-sm btn-success">Enroll</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
@endsection