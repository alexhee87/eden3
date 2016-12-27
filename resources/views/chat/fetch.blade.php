<ul class="chat">
@foreach($chats as $chat)
    @include('chat/single_list')
@endforeach
</ul>