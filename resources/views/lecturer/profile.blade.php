@extends('layouts.lecturer')

@section('content')
<div class="container">
    <div class="main-body">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">User : {{ Auth::user()->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <div class="row gutters-sm" id="info">
            <div class="col-md-4 mb-3">
                <div class="card" style="border-radius:20px;">
                    <div class="card-body" style="background: #3ba7ff;border-radius:20px;">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                alt="user{{ Auth::user()->username }}" class="rounded-circle" width="150"
                                style="border: white 2px solid;">
                            <div class="mt-3">
                                <h4 style="color: white;text-transform: uppercase">{{ Auth::user()->username }}</h4>
                                <p style="color: white">Student</p>
                                <p style="color: white">{{ Auth::user()->address }} - {{ Auth::user()->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3" style="border-radius:20px;">
                    <div class="card-body">
                        <div class="float-right" style="cursor: pointer;">
                            <a style="text-decoration: none;cursor: pointer" onclick="$('#edit').toggle('slow'); $('#info').hide('fast'); return false;">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        </div>
                        <div class="row" style="margin-top: 25px">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">User Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->username }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->phone }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->address }}
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gutters-sm" id="edit" style="display: none">
            <div class="col-md-4 mb-3">
                <div class="card" style="border-radius:20px;">
                    <div class="card-body" style="background: #fff;border-radius:20px;">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="user{{ Auth::user()->username }}"
                                class="rounded-circle" width="150" style="border: white 2px solid;">
                            <div class="mt-3">
                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    <a href="" onclick="$('#imageInput').click(); return false;" class="btn btn-outline-dark">Change Picture</a>
                                    <form method="post" style="display: none;" action="{{ route('userLecturer.updateImage', Auth::user()) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input id="imageInput" style="border: none" onchange="document.getElementById('upload').click();" type="file"
                                            name="image">
                                        <input type="submit" name="upload" id="upload">
                                    </form>
                                    <a href="" onclick="$('#restore').submit(); return false;" class="btn btn-outline-dark">Restore Default</a>
                                    <form style="display: none" method="POST" action="{{ route('userLecturer.restoreImage', Auth::user()) }}" id="restore">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 10px;" class="justify-content-center">
                    <center><button style="animation: drop 0.8s" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteAcount" >Delete Account</button></center>
                    <form id="delete" style="display: none" action="{{ route('userLecturer.delete', Auth::user()) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    <div class="modal fade" id="deleteAcount" tabindex="-1" role="dialog" aria-labelledby="deleteAcount"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete your account {{Auth::user()->name}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" role="alert">
                                        <h4 class="alert-heading">By Deleteing Your Account!</h4>
                                        All of Your Records will be deleted Permanently!<br>
                                        Are you sure?
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, I'm not so sure</button>
                                    <button onclick="document.getElementById('delete').submit();" type="button" class="btn btn-danger">Yes, Sure. Delete My Account</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3" style="border-radius:20px;">
                    <form method="post" action="{{ route('userLecturer.update', Auth::user()) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="float-right" style="cursor: pointer;">
                                <a style="text-decoration: none ;cursor: pointer" onclick="$('#info').toggle('slow'); $('#edit').hide('fast'); return false;">Close <i class="fa fa-times" aria-hidden="true"></i></a>
                            </div>
                            <div class="row" style="margin-top: 25px">
                                <div class="col-sm-12">
                                    <label for="name">Full Name</label>
                                    <input name="name" type="text" class="form-control" value="{{ Auth::user()->name }}" placeholder="Enter Your Full Name">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="username">User Name</label>
                                    <input name="username" type="text" class="form-control" value="{{ Auth::user()->username }}" placeholder="Enter Your UserName">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="email">Email</label>
                                    <input name="email" type="text" class="form-control" value="{{ Auth::user()->email }}" placeholder="Enter Your Email">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="phone">Phone</label>
                                    <input name="phone" type="text" class="form-control" value="{{ Auth::user()->phone }}" placeholder="Enter Your Phone">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="address">Address</label>
                                    <input name="address" type="text" class="form-control" value="{{ Auth::user()->address }}" placeholder="Enter Your Address">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="margin-top: 10px">
                                    <button class="btn btn-outline-dark" style="float: right">Change</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection