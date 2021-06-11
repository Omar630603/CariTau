@extends('layouts.adminApp')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-10">
            <div class="card" style="padding: 10px">
                <div class="card-header text-center" style="margin-bottom: -20px">
                    <h4 class="card-title">Latest Comments</h4>
                </div>
                @if (count($contact_us)>0)
                @foreach ($contact_us as $c)
                <div class="d-flex flex-row comment-row m-t-0" style="margin-top: 10px; border-bottom: 1px solid #ccc; padding: 20px">
                    <div class="p-2">
                        <img src="{{ asset('storage/images/ICON2.png') }}" alt="user" width="50" class="rounded-circle">
                    </div>
                    <div class="comment-text w-100" style="margin-left: 5px">
                        <span style="margin-right:15px" class="text-muted float-right">{{$c->created_at}}</span>
                        <h6 class="font-medium"><strong>{{$c->name}}</strong></h6> 
                        <h6 style="margin-left: 10px" class="font-small"><i>{{$c->subject}}</i></h6> 
                        <span class="m-b-15 d-block" style="margin-left: 20px">{{$c->message}} </span>
                        <div class="comment-footer" style="margin: 10px">
                            <div class="float-right">
                                <a href="" type="button" class="btn btn-dark btn-sm">Reply</a>
                                @if ($c->show)
                                <a href="{{route('admin.commentsUnPublish', $c)}}" type="button" class="btn btn-primary btn-sm">Unpublish</a>    
                                @else
                                <a href="{{route('admin.commentsPublish', $c)}}" type="button" class="btn btn-success btn-sm">Publish</a>
                                @endif 
                                <a href="{{route('admin.commentsAdminDelete', $c)}}" type="button" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="container mt-5">
                    <div class="d-flex">
                        @if (is_array($contact_us) || is_object($contact_us))
                        {{$contact_us->links("pagination::bootstrap-4")}}
                        @endif
                    </div>
                </div>
                @else
                <p>There are no comments yet! :(</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection