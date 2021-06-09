@extends('layouts.welcome')
@section('content')
<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="row">
                            <h3 class="heading mb-4">Let's talk about everything!</h3>
                            <p>We can talk about everything! just send a message :)</p>
                            <p><img src="{{ asset('storage/images/contact.svg') }}" alt="Image" class="img-fluid"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form class="mb-5" method="post" id="contactForm" name="contactForm">
                            @auth
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="text" hidden name="name" id="name" placeholder="Your name" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="text" hidden class="form-control" name="email" id="email"
                                        placeholder="Email" value="{{Auth::user()->email}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <a href="" class="float-right" style="margin-right: 5px"><img width="80px"
                                            height="80px"
                                            style="border-radius: 50%; border: 2px solid #6c63ff; padding: 2px"
                                            src="{{asset('storage/'.Auth::user()->image)}}">
                                    </a>
                                    <strong>
                                        <p class="card-title">Hello! {{Auth::user()->username}}</p>
                                    </strong>
                                    <p class="card-text">E-Mail: {{Auth::user()->email}}</p>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="subject" id="subject"
                                        placeholder="Subject">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="message" id="message" cols="30" rows="7"
                                        placeholder="Write your message"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <input type="submit" value="Send Message"
                                        class="btn btn-primary rounded-0 py-2 px-4">
                                    <span class="submitting"></span>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Your name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="subject" id="subject"
                                        placeholder="Subject">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="message" id="message" cols="30" rows="7"
                                        placeholder="Write your message"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <input type="submit" value="Send Message"
                                        class="btn btn-primary rounded-0 py-2 px-4">
                                    <span class="submitting"></span>
                                </div>
                            </div>
                            @endauth
                        </form>
                        <div id="form-message-warning mt-4"></div>
                        <div id="form-message-success">
                            Your message will be sent, we will contact you soon. Thank you!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection