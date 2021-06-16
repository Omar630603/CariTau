@extends('layouts.welcome')
<style>
    .carousel .carousel-item {
    height: 270px;
    }
    
    .carousel-item img {
    position: absolute;
    object-fit:cover;
    top: 0;
    left: 0;
    min-height: 500px;
    }
</style>
@section('content')
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow1.png') }}" alt="First slide">
                    <div class="carousel-caption">
                        <h1>Welcome!</h1>
                        <p>Cari Tau is here to help you</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow2.png') }}" alt="Second slide">
                    <div class="carousel-caption">
                        <h1>Find Information!</h1>
                        <p>“Education is the passport to the future, for tomorrow belongs to those who prepare for it today.” — Malcolm X</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow3.png') }}" alt="Third slide">
                    <div class="carousel-caption">
                        <h1>Look Forward</h1>
                        <p>Here, in CariTau We provide best class education in the fields of engineering</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow4.png') }}" alt="Fourth slide">
                    <div class="carousel-caption">
                        <h1>Keep Looking</h1>
                        <p>We provide courses that contain materials which has been selected by our team. Navigate many Courses and interact with
                        materials</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow5.png') }}" alt="Fifth slide">
                    <div class="carousel-caption">
                        <h1>Keep Fighting</h1>
                        <p>“When one door closes, another opens; but we often look so long and so regretfully upon the closed door that we do not
                        see the one which has opened for us.”
                        
                        – Alexander Graham Bell</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('storage/images/slidshow6.png') }}" alt="Fifth slide">
                    <div class="carousel-caption">
                        <h1>Keep the hard Work!</h1>
                        <p>“Success consists of going from failure to failure without loss of enthusiasm.”
                        
                        – Winston Churchill</p>
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
    <div class="container" style="margin-top: 1rem">
            <h4 style="margin: 1rem 0;
                background: #3445b4;background: linear-gradient(rgb(52, 69, 180), rgba(52, 69, 180, 0.8));border-radius:20px; color: #fff;padding:10px; text-align: center">
               <center>Majors in CariTau</center>
            </h4>
            <div style="display: flex; flex-wrap: wrap; gap: 40px; justify-content: space-evenly">
            @if (count($majors) > 0)
            @foreach ($majors as $major)
                <div class="card " style="width: 12rem">
                    <img class="card-img-top" src="{{ asset('storage/' . $major->image) }}" alt="Card image cap">
                    <div class="card-body d-flex flex-column" style="margin-top: 5px">
                        <strong style="margin-bottom: 5px">
                            <h4 class="card-title" style="text-align: center; font-weight: bold;">{{ $major->major_name }}</h4>
                        </strong>
                        <span class="mt-auto" data-toggle="collapse" data-target="#major{{$major->ID_major}}" href="#major{{$major->ID_major}}">
                        <a class="mt-auto btn btn-outline-dark"  
                            data-toggle="tooltip" role="button" onclick="scrolls({{ $major->ID_major }}); return false"
                            title="Double click to view content" style="width: 100%" >Courses</a>
                        </span>
                    </div>
                </div>
            @endforeach
            @else
            <h5 style="margin-left: 10px" class="card-title">There are no Majors yet! :(</h5>
            @endif
            </div>
        @foreach ($majors as $major)
            <div class="row" style="margin-left: 0;margin-right: 0;">
                <div class="collapse multi-collapse" id="major{{$major->ID_major}}" style="width: 100%">
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
                                <div class="card-body d-flex flex-column" style="margin-bottom: 5px">
                                    <strong>
                                        <h4 class="card-title" style="text-align: center; font-weight: bold;">{{$course->course_name}}</h4>
                                    </strong>
                                    @auth
                                        @if (is_array($enrollment) || is_object($enrollment))
                                            @if (in_array($course->ID_course, $enrollment))
                                                <a href="{{route('course', $course)}}"style="border-radius:20px;" class="mt-auto btn btn-warning">Access</a>
                                            @else
                                            <a href="{{route('course', $course)}}" style="border-radius:20px;" class="mt-auto btn btn-outline-success">Enroll</a>
                                            @endif
                                        @else
                                        <a href="{{route('course', $course)}}" style="border-radius:20px;" class="mt-auto btn btn-outline-success">Enroll</a>
                                        @endif
                                    @else
                                    <a href="{{route('redirectLogin')}}" style="border-radius:20px;" class="mt-auto btn btn-success">Learn more</a>
                                    @endauth
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
