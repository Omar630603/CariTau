@extends('layouts.adminApp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    {{-- {{ __('lecturers!') }} --}}
                    <div class="main center">
                        <div class="box center">
                            <img src="{{ asset('storage/images/profile.jpeg') }}" alt="">
                            <div>
                                <p class="user_name">Rivaldo Ferby</p>
                                <p class="skill">Front-end Developer</p>
                            </div>
                            <div class="arr_container center">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <div class="left_container off">
                                <p>Skills</p>
                                <div class="skills">
                                    <div>Html</div>
                                    <div>Html2</div>
                                    <div>Html3</div>
                                    <div>Html4</div>
                                </div>
                                <div class="icons">
                                    <i class="fab fa-github"></i>
                                    <i class="fab fa-linkedin"></i>
                                    <i class="fab fa-twitter"></i>
                                    <i class="fab fa-facebook"></i>
                                </div>
                                <div class="cancel center">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const clc = document.querySelector(".cancel");
    const arr = document.querySelector(".arr_container");
    const left_container = document.querySelector(".left_container");

    arr.addEventListener("click",()=>{
        arr.classList.add("active_arr");
        if(left_container.classList.contains("off")){
            left_container.classList.remove("off");
            left_container.classList.add("active");
        }
    });
    clc.addEventListener("click",()=>{
        arr.classList.remove("active_arr");
        if(left_container.classList.contains("active")){
            left_container.classList.remove("active");
            left_container.classList.add("off");
        }
    });
</script>
@endsection