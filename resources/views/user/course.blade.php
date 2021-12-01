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
                    <a style="text-decoration: none; margin-top:10px" class="logo">{{$major->major_name}}
                        <span>{{$major->description}}
                        </span>
                    </a>
                </h1>
                <ul class="list-unstyled components mb-5">
                    @foreach ($courses as $c)
                    @if ($c->ID_course == $course->ID_course)
                    <li class="active">
                        <a href="{{route('course', $c)}}"><span
                                class="fas fa-book-open mr-3"></span>{{$c->course_name}}</a>
                    </li>
                    @else
                    <li>
                        <a href="{{route('course', $c)}}"><span
                                class="fas fa-book-open mr-3"></span>{{$c->course_name}}</a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            @if ($message = Session::get('fail'))
            <div class="alert alert-warning p-3 ml-4">
                <p><strong>{{ $message }}!</strong></p>
            </div>
            @elseif ($message = Session::get('success'))
            <div class="alert alert-success p-2 ml-4">
                <p>{{ $message }}</p>
            </div>
            @endif
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
                            style="text-align: center;border-radius:20px; background:linear-gradient(rgba(0, 0, 0, 0.6),rgba(0, 0, 0, 0.6)), url({{ asset('storage/' . $course->image) }});background-position: center;">
                            <h6 class="d-flex align-items-center mb-3"
                                style="border-radius:20px; background-color: #e9ecef;padding:10px;">
                                <i class="material-icons text-info mr-2"></i>{{ $course->course_name }}
                            </h6>
                            <h5 style="color: #fff;">
                                {{ $course->description }}
                            </h5>
                            @if (is_array($enrollment) || is_object($enrollment))
                            @if ($enrollment->status == 1)
                            <a disabled style="border-radius:20px;" class="mt-auto btn btn-success">Full Access</a>
                            @elseif($enrollment->status == 0)
                            @if (is_array($transaction) || is_object($transaction))
                            @if ($transaction->approve == 0)
                            <div class="mt-auto" style="display: flex; justify-content: space-between; gap:5px">
                                <a data-toggle="tooltip"
                                    title="You will be notified to your email when the transaction has been approved"
                                    disabled style="border-radius:20px; width: 100%" class="mt-auto btn btn-light">
                                    Pending, Waiting for the approval process. Please, be patient. Thank you :)
                                </a>
                            </div>
                            @elseif($transaction->approve == 1)
                            <div class="mt-auto" style="display: flex; justify-content: space-between; gap:5px">
                                <a data-toggle="tooltip"
                                    title="Your transaction has been approved. You can contact Us if this happens we will change the course access"
                                    disabled style="border-radius:20px; width: 100%" class="mt-auto btn btn-secondary">
                                    Wait for the course access change. Thank you :)
                                </a>
                            </div>
                            @elseif($transaction->approve == 2)
                            <div class="mt-auto" style="display: flex; justify-content: space-between; gap:5px">
                                <a data-toggle="tooltip"
                                    title="This happend because of an issue with your transaction, Contact Us to Fix it."
                                    disabled style="border-radius:20px; width: 100%" class="mt-auto btn btn-danger">
                                    Your Transaction has been Disapproved
                                </a>
                            </div>
                            @endif
                            @else
                            <div class="mt-auto" style="display: flex; justify-content: space-between; gap:5px">
                                <a data-toggle="tooltip" title="You have a preview access to this course" disabled
                                    style="border-radius:20px; width: 100%" class="mt-auto btn btn-dark">Preview</a>
                                <span data-toggle="modal" data-target="#paying">
                                    <a data-toggle="tooltip" title="Pay for this Course and Get Full Access"
                                        style="border-radius:20px; width: 100%" class="mt-auto btn btn-success">Buy</a>
                                </span>
                                <div class="modal fade" id="paying" data-backdrop="static" data-keyboard="false"
                                    tabindex="-1" role="dialog" aria-labelledby="paying" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered " role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Buy
                                                    {{$course->course_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if (count($banks)>0)
                                                <div class="alert alert-info" role="alert">
                                                    <h4 class="alert-heading">Buying Course {{$course->course_name}}
                                                    </h4>
                                                    You will have full access to all the materials in this course!<br>
                                                    <strong>This Course Cost Rp.{{$course->price}}</strong>
                                                </div>
                                                <div style="text-align: left" class="m-3">
                                                    <form action="{{route('user.payCourse')}}" id="payForm"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <label for="ID_bank">Bank</label>
                                                        <select id="bank" class="form-control mb-2" type="text"
                                                            name="ID_bank">
                                                            <option id="nothing" value="0" selected disabled hidden>
                                                                Click here to choose a Bank From
                                                                the List Below</option>
                                                            @foreach ($banks as $bank)
                                                            <option id="ID_bank" value="{{$bank->ID_bank}}">
                                                                {{$bank->bank_name}} -
                                                                {{$bank->no_account}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="image">Proof</label>
                                                        <div class="alert alert-warning p-2 mt-2">
                                                            Send Rp.{{$course->price}} to the bank account you have
                                                            chosen.
                                                            <br> Upload the receipt to as a proof. Image only
                                                            <input type="file" style="padding: 4px"
                                                                class="form-control mt-3" name="image" accept="image/*">
                                                        </div>
                                                        <input hidden name="ID_course" value="{{$course->ID_course}}">
                                                        <input hidden name="transaction" value="{{$course->price}}">
                                                    </form>
                                                </div>
                                                <div class="table-responsive custom-table-responsive">
                                                    <div class="container float-right m-2">
                                                        <h4>List of Official CariTau Bank Accounts</h4>
                                                    </div>
                                                    <table class="table custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Bank</th>
                                                                <th scope="col">Account NO.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $no =0 ;
                                                            @endphp
                                                            @if (count($banks)>0)
                                                            @foreach ($banks as $bank)
                                                            <tr scope="row">
                                                                <th scope="row">
                                                                    @php
                                                                    $no++
                                                                    @endphp
                                                                    {{$no++}}
                                                                </th>
                                                                <td><a href="">{{$bank->bank_name}}</a></td>
                                                                <td>
                                                                    {{$bank->no_account}}
                                                                    <small class="d-block">Official CariTau Bank
                                                                        Account</small>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @else
                                                            <div style="text-align: center"
                                                                class="container float-right m-2">
                                                                <h4>There are no banks yet :(</h4>
                                                            </div>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">No, cancel</button>
                                                    <a onclick="document.getElementById('payForm').submit();"
                                                        type="button" class="btn btn-success">Yes, buy</a>
                                                </div>
                                                @else
                                                <div class="alert alert-info" role="alert">
                                                    <h4 class="alert-heading">We are Sorry! We have a Problem Right Now
                                                    </h4>
                                                    Please, try in another time :)<br>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span data-toggle="modal" data-target="#unenrolling">
                                    <a data-toggle="tooltip" title="Unenroll in This Course"
                                        style="border-radius:20px;width: 100%"
                                        class="mt-auto btn btn-danger">Unenroll</a>
                                </span>
                                <div class="modal fade" data-backdrop="static" data-keyboard="false" id="unenrolling"
                                    tabindex="-1" role="dialog" aria-labelledby="unenrolling" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">
                                                    {{$course->course_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-danger" role="alert">
                                                    <h4 class="alert-heading">Unenrolling in Course
                                                        {{$course->course_name}}</h4>
                                                    You will unenroll in this course it will not be showen in your
                                                    courses!<br>
                                                    Are you sure?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No,
                                                    I'm not so sure</button>
                                                <a href="{{route('Unenroll', $course)}}" type="button"
                                                    class="btn btn-danger">Yes, I'm sure</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                            @else
                            <a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#enrolling"
                                style="border-radius:20px;" class="mt-auto btn btn-outline-success">Enroll</a>
                            <div class="modal fade" id="enrolling" tabindex="-1" role="dialog"
                                aria-labelledby="enrolling" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">{{$course->course_name}}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-info" role="alert">
                                                <h4 class="alert-heading">Enrolling in Course {{$course->course_name}}
                                                </h4>
                                                You will enroll in this course and will have access to the first
                                                material!<br>
                                                Are you in?
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, I'm
                                                not so sure</button>
                                            <a href="{{route('enroll', $course)}}" type="button"
                                                class="btn btn-success">Yes, I would like to enroll</a>
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
                            <div
                                style="display: flex; flex-direction: column; justify-content: space-between;width: 100%">
                                @foreach ($materials as $material)
                                <div class="container">
                                    <div class="card">
                                        <div class="card-body d-flex"
                                            style="flex-direction: row; justify-content: space-between">
                                            @if (is_array($enrollment) || is_object($enrollment))
                                            @if ($enrollment->status == 1)
                                            <strong
                                                style="margin-bottom: 5px; margin-right: 5px">#{{$material->order}}</strong>
                                            <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}"
                                                style="text-decoration: none">
                                                <p class="materialName">{{ $material->material_name }}</p>
                                                <span
                                                    style="color: #44bef1;margin-right: 5px">{{$material->description}}</span>
                                            </a>
                                            <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }} "
                                                data-toggle="tooltip" title="Full Access"
                                                class="mt-auto btn btn-sm btn-primary">Access</a>
                                            @elseif($enrollment->status == 0)
                                            @if ($material->order == 1)
                                            <strong
                                                style="margin-bottom: 5px; margin-right: 5px">#{{$material->order}}</strong>
                                            <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}"
                                                data-toggle="tooltip" title="First Material / Free" href=""
                                                style="text-decoration: none">
                                                <p class="materialName">{{ $material->material_name }}</p>
                                                <span
                                                    style="color: #44bef1;margin-right: 5px">{{$material->description}}</span>
                                            </a>
                                            <a href="{{ route('material', ['course'=>$course, 'material'=>$material]) }}"
                                                class="mt-auto btn btn-sm btn-primary">Access</a>
                                            @else
                                            <strong
                                                style="margin-bottom: 5px; margin-right: 5px">#{{$material->order}}</strong>
                                            <a data-toggle="tooltip"
                                                title="Buy the Course to Access the Rest of the Materials" disabled
                                                style="text-decoration: none">
                                                <p class="materialName">{{ $material->material_name }}</p>
                                                <span
                                                    style="color: #44bef1;margin-right: 5px">{{$material->description}}</span>
                                            </a>
                                            <button disabled class="mt-auto btn btn-sm btn-dark">Deluxe</button>
                                            @endif
                                            @endif
                                            @else
                                            <strong
                                                style="margin-bottom: 5px; margin-right: 5px">#{{$material->order}}</strong>
                                            <a data-toggle="tooltip"
                                                title="Enroll in the Course to Access the First Material" disabled
                                                style="text-decoration: none">
                                                <p class="materialName">{{ $material->material_name }}</p>
                                                <span
                                                    style="color: #44bef1;margin-right: 5px">{{$material->description}}</span>
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