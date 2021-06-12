@extends('layouts.lecturer')
<style>
    .display-comment .display-comment {
        margin-left: 40px
    }
</style>
@section('content')
<div class="container">
    <div>
        @if ($message = Session::get('fail'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    This is Forum for <a href="{{ route('lecturer.materialDetails', $material) }}">{{$material->material_name}}</a> Material
                </div>
                <div class="card-body">
                    <p><b>{{ $forum->title }}</b></p>
                    <p>
                        {{ $forum->body }}
                    </p>
                    <hr />
                    <h4>Display Comments</h4>
                    @include('lecturer.partials._comment_replies', ['comment' => $forum->comment, 'ID_forum' =>
                    $forum->ID_forum])
                    <hr />
                    <h4>Add comment</h4>
                    <form method="post" action="{{ route('lecturer.addForumComment') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="comment_body" class="form-control" />
                            <input type="hidden" name="post_id" value="{{ $forum->ID_forum }}" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-dark" value="Add Comment" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection