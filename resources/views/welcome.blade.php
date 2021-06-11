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
            <h5 class="card-title">This is a list of courses in CariTau</h5>
        </div>
        <div class="row" style="margin-left: 0">
            <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: space-between">
            @if (count($courses) > 0)
                @foreach ($courses as $course)
                    <div class="card" style="width: 15rem;">
                        <img class="card-img-top" src="{{ asset('storage/' . $course->image) }}" alt="Card image cap">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $course->course_name }}</h5>
                            <p class="card-text">{{ $course->description }}</p>
                            <a href="#" class="mt-auto btn btn-success">Learn more</a>
                        </div>
                    </div>
                @endforeach
            @else
                <h5 class="card-title">There are no courses yet! :(</h5>
            @endif
            </div>
        </div>
    </div>
@endsection
