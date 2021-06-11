@extends('layouts.welcome')
@section('content')
<div class="container" style="margin-top: 0.5rem">
    <div class="row mb-5" style="display: flex; flex-direction: row-reverse">
        <div class="col-lg-6 order-2 order-lg-1" style="padding: 10px">
            <p class="font-italic text-muted mb-4">We provide our students with the best class education.<br>We have
                <strong>{{count($courses)}}</strong> courses in CariTau with qualified lecturers.
            </p>
        </div>
        <div class="col-lg-6 mx-auto" style="margin: 10px">
            <form>
                <div class="row mb-4">
                    <form action="{{route('courses')}}" method="get">
                        @csrf
                        <div class="form-group col-md-9">
                            <input id="search" name="search" type="type" placeholder="Search for a course?"
                                class="form-control form-control-underlined">
                        </div>
                        <div class="form-group col-md-3">
                            <button type="submit"
                                class="btn btn-primary rounded-pill btn-block shadow-sm">Search</button>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
    <div class="card-header" style="margin-bottom: 1rem">
        <h5 class="card-title">This is a list of all the courses in CariTau</h5>
    </div>
    <div class="row" style="margin-left: 0">
    <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: space-between">
        @if (count($courses)>0) @foreach ($courses as $course) <div class="card" style="width: 15rem;">
            <img class="card-img-top" src="{{ asset('storage/'.$course->image) }}" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{$course->course_name}}</h5>
                <p class="card-text">{{$course->description}}</p>
                <a href="#" class="mt-auto btn btn-success">Study!</a>
            </div>
        </div>
        @endforeach
        @else
        <div class="container justify-content-center">
            @if ($search)
            <center>
                <h5 class="card-title">There are no courses with the name: {{$search}}! :(</h5>
            </center>
            @else
            <center>
                <h5 class="card-title">There are no courses yet! :(</h5>
            </center>
            @endif
        </div>
        @endif
    </div>
    </div>
</div>
@endsection