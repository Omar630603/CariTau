@foreach($comment as $c)
<div class="display-comment" style="border-left: 1px solid #cccc;">
    <strong style="padding-left: 10px">
        <a href="{{ route('admin.userDetails', $c->user->ID_user) }}">
            <img width="35px" height="35px" style="border-radius: 50%" src="{{asset('storage/'.$c->user->image)}}">
        </a>
        {{ $c->user->username }}
    </strong>
    <p style="margin-left: 40px; padding-left: 10px">{{ $c->body }}
        <a href="" onclick="$('#formReply{{ $c->ID_comment }}').toggle('slow'); return false;" id="reply">
            <i class="fa fa-reply" aria-hidden="true"></i>
        </a>
        @if ($c->user->ID_user == Auth::user()->ID_user)
        <a href="" onclick="document.getElementById('deleteComment{{$c->ID_comment}}').click(); return false;">
            <i class="fa fa-trash-o"></i>
        </a>
        @endif
        <div style="display: none">
            <form action="{{route('admin.deleteComment', $c)}}" method="POST">
                @csrf
                @method('DELETE')
                <button id="deleteComment{{$c->ID_comment}}" type="submit"></button>
            </form>
        </div>
    </p>

    <form style="display: none; margin-left: 40px" method="post" action="{{ route('admin.addForumCommentReply') }}"
        id="formReply{{ $c->ID_comment }}">
        @csrf
        <div class="form-group">
            <input type="text" name="comment_body" class="form-control" />
            <input type="hidden" name="post_id" value="{{ $ID_forum }}" />
            <input type="hidden" name="comment_id" value="{{ $c->ID_comment }}" />
        </div>
        <div class="form-group" style="float: right;">
            <input type="submit" class="btn btn-sm btn-dark" value="Reply" />
        </div>
    </form>
    @include('admin.partials._comment_replies', ['comment' => $c->replies])
</div>
@endforeach