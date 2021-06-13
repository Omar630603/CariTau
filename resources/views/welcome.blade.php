@extends('layouts.welcome')
@section('content')
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow1.png') }}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>...</h5>
                        <p>...</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow2.png') }}" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>...</h5>
                        <p>...</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow3.png') }}" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>...</h5>
                        <p>...</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="container" style="margin-top: 3rem">
        <div class="card-header" style="margin-bottom: 1rem">
            <h5 class="card-title">Majors in CariTau</h5>
        </div>
        <div class="row" style="margin-left: 0;margin-right: 0">
            <div style="display: flex; flex-wrap: wrap; gap: 40px; justify-content: space-between">
            @if (count($majors) > 0)
            @foreach ($majors as $major)
                <div class="card " style="width: 15.4rem">
                    <img class="card-img-top" src="{{ asset('storage/' . $major->image) }}" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $major->major_name }}</h5>
                        <a id="btnMajo{{$major->ID_major}}" class="mt-auto btn btn-outline-success"  
                            data-toggle="collapse" href="#major{{$major->ID_major}}" role="button" aria-expanded="false"
                            aria-controls="major{{$major->ID_major}}">Courses</a>
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="tooltip"
                            title="After Clicking on Courses, Click to view content" data-placement="bottom" style="margin-top: 5px;" onclick="scrolls({{ $major->ID_major }})"><i class="fa fa-arrow-down" aria-hidden="true"></i>
                            </button>
                    </div>
                </div>
            @endforeach
            @else
            <h5 style="margin-left: 10px" class="card-title">There are no Majors yet! :(</h5>
            @endif
            </div>
            </div>
        @foreach ($majors as $major)
            <div class="row" style="margin-left: 0;margin-right: 0">
                <div class="collapse multi-collapse" id="major{{$major->ID_major}}">
                    <div class="card-header" style="width: 100%; background:linear-gradient(rgba(0, 0, 0, 0.2),rgba(0, 0, 0, 0.6)), url({{ asset('storage/' . $major->image) }});
                    background-position: center; border-radius:20px; margin-bottom: 20px; margin-top: 20px">
                        <center>
                            <h5 class="card-title" style="font-weight: 900;color: white;text-transform: uppercase;">{{ $major->major_name }}</h5>
                        </center>
                    </div>
                    <div class="row" style="margin-left: 0;margin-right: 0">
                        <div style="display: flex; flex-wrap: wrap; gap: 50px; justify-content: space-between">
                            @if (count($courses) > 0)
                            @foreach ($courses as $course)
                            @if ($course->ID_major == $major->ID_major)
                            <div class="card card-course">
                                <img class="card-img-top" src="{{ asset('storage/' . $course->image) }}" alt="Card image cap">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $course->course_name }}</h5>
                                    <a href="{{route('redirectLogin')}}" class="mt-auto btn btn-success">Learn more</a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @else
                                <h5 class="mt-auto card-title">There are no courses yet! :(</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        function scrolls(w) {
            var elmnt = document.getElementById("major"+w);
            elmnt.scrollIntoView();
    }
    </script>
@endsection
