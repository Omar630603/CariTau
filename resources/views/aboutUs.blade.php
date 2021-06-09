@extends('layouts.welcome')
@section('content')
<div class="container">
    <div class="bg-light" style="margin-top: -40px">
        <div class="container py-5">
            <img src="{{ asset('storage/images/ICON2.png') }}" width="200px" height="200px" alt="Image"
                class="img-fluid float-right">
            <div class="row h-100 align-items-center py-5" style="margin-top: -10px">
                <h1 class="display-4">About CariTau</h1>
                <p class="lead text-muted mb-0">Cari Tau is an application that provides services and educational
                    content. Cari Tau is here to help and facilitate students,
                    lecturers, and the public who want to study engineering subjects by understanding and completing
                    materials and assignments. With a website that is easily accessible only by the internet network
                    and can be used on various gadgets, one of which is a smartphone.</p>
                </p>
            </div>
        </div>
    </div>
    <div class="bg-white py-5">
        <div class="container py-5" style="margin-top: -50px">
            <div class="row align-items-center">
                <div style="display: flex; flex-direction: row">
                    <div class="col-lg-5 px-5 mx-auto">
                        <img src="{{ asset('storage/images/goal.png') }}" alt="" class="img-fluid mb-4 mb-lg-0">
                    </div>
                    <div class="col-lg-6"><i class="fa fa-leaf fa-2x mb-3 text-primary"></i>
                        <h2 class="font-weight-light">Our Goals</h2>
                        <p class="font-italic text-muted mb-4">
                            - Building an application as a facility for all groups of people to help them improve in
                            their
                            aspired dreams.
                        </p>
                        <p class="font-italic text-muted mb-4">
                            - All users get an understanding of information related to the material in the engineering
                            field
                        </p>
                        <p class="font-italic text-muted mb-4">
                            - All users have easy access for materials by looking for information in the
                            technical field provided on our website.
                        </p>
                        <a href="#" class="btn btn-light px-5 rounded-pill shadow-sm">Learn
                            More</a>
                    </div>
                </div>
            </div>
            <div style="display: flex; flex-direction: row-reverse; margin-top: 20px">
                <div class="col-lg-6 order-2 order-lg-1"><i class="fa fa-bar-chart fa-2x mb-3 text-primary"></i>
                    <h2 class="font-weight-light">CariTau Statistics</h2>
                    <p class="font-italic text-muted mb-4">CariTau has <strong>{{$students}}</strong> students from
                        different parts of
                        the world. We provide our students with the best class education. We have
                        <strong>{{$courses}}</strong> courses in
                        CariTau with
                        qualified lecturers. There are <strong>{{$lecturers}}</strong> selected lecturers who are
                        building and updating courses in CariTau. There are <strong>{{$enrollment}}</strong> enrollments
                        in
                        CariTau's courses
                        from different Users.
                    </p>
                    <a href="#" class="btn btn-light px-5 rounded-pill shadow-sm">Learn
                        More</a>
                </div>
                <div class="col-lg-5 px-5 mx-auto">
                    <img src="{{ asset('storage/images/statistics.png') }}" alt="" class="img-fluid mb-4 mb-lg-0">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light py-5">
        <div class="container py-5">
            <div class="row mb-4">
                <div class="col-lg-5">
                    <h2 class="display-4 font-weight-light">Our team</h2>
                    <p class="font-italic text-muted">This is our development team :).</p>
                </div>
            </div>

            <div class="row text-center">
                <!-- Team item-->
                <div class="col-xl-3 col-sm-6 mb-5">
                    <div class="bg-white rounded shadow-sm py-5 px-4"><img src="{{ asset('storage/images/omar.jpg') }}"
                            alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0">Omar Al-Maktary</h5><span class="small text-uppercase text-muted">Programer &
                            Engineer</span>
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End-->
                <!-- Team item-->
                <div class="col-xl-3 col-sm-6 mb-5">
                    <div class="bg-white rounded shadow-sm py-5 px-4"><img
                            src="{{ asset('storage/images/rivaldo.png') }}" alt="" width="100"
                            class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0">Rivaldo Ferby A.</h5><span
                            class="small text-uppercase text-muted">Management</span>
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End-->
                <!-- Team item-->
                <div class="col-xl-3 col-sm-6 mb-5">
                    <div class="bg-white rounded shadow-sm py-5 px-4"><img src="{{ asset('storage/images/alif.jpeg') }}"
                            alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0">M.Alif Ananda</h5><span class="small text-uppercase text-muted">Data
                            analyst</span>
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End-->
                <!-- Team item-->
                <div class="col-xl-3 col-sm-6 mb-5">
                    <div class="bg-white rounded shadow-sm py-5 px-4"><img src="{{ asset('storage/images/rizky.png') }}"
                            alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0">Rizky Irfan Maulana</h5><span
                            class="small text-uppercase text-muted">Designer</span>
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><i
                                        class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End-->
            </div>
        </div>
    </div>
</div>
@endsection