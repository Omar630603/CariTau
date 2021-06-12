@extends('layouts.lecturer')

@section('content')
<h3 id="greetings" style="margin: 20px"><b>Lecturer:</b> <a href="{{ route('lecturer.profile')}}"
        style="text-decoration: none">{{Auth::user()->username }}</a><br></h3>
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
                        {{ __('You are logged in as Lecturer!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var myDate = new Date();
        var hrs = myDate.getHours();
        var greet;
        if (hrs < 12)
            greet = 'Good Morning';
        else if (hrs >= 12 && hrs <= 17)
            greet = 'Good Afternoon';
        else if (hrs >= 17 && hrs <= 24)
            greet = 'Good Evening';
        document.getElementById('greetings').innerHTML +=
            '<b>' + greet + '!</b> Welcome to CariTau dashboard.';
    </script>
@endsection
