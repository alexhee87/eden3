<ul class="chat">
@foreach($chats as $chat)
    <li class="{{($chat->user_id == Auth::user()->id) ? 'right' : 'left'}} clearfix">
        <span class="chat-img pull-{{($chat->user_id == Auth::user()->id) ? 'right' : 'left'}}">
            {!! getAvatar($chat->user_id,45) !!}
        </span>
        <div class="chat-body clearfix">
            <div class="header">
                <strong class="primary-font">{{$chat->User->full_name}}</strong>
                <small class="pull-right text-muted">
                    <i class="fa fa-clock-o fa-fw"></i> {{timeAgo($chat->created_at)}}
                </small>
            </div>
            <p>
                {{$chat->message}}
            </p>
        </div>
    </li>
@endforeach
</ul>