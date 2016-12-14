	{!! getAvatar($message->from_user_id,45) !!}
		<div style="float:left;margin-left:10px;margin-bottom: 20px;">
		<strong class="primary-font">{{$message->UserFrom->full_name}}</strong> 
		<a href="#" data-source="/message/starred" data-extra="&token={{$message->token}}" data-ajax="1" data-refresh="load-message">
			@if((Auth::user()->id == $message->from_user_id && $message->is_starred_sender) || (Auth::user()->id == $message->to_user_id && $message->is_starred_receiver))
				<i class="fa fa-star fa-lg starred"></i>
			@else
				<i class="fa fa-star-o fa-lg starred"></i>
			@endif
		</a>
		<br />
		{{showDateTime($message->created_at)}}
	</div>
	
	<div class="pull-right">
		<div class="btn-group btn-group-xs">
			<a href="#" data-href="/message/forward/{{$message->token}}" data-target="#myModal" data-toggle="modal" class="btn btn-default btn-xs">
				<i class="fa fa-share"></i>
			</a>
			{!! delete_form(['message.trash',$message->id],['refresh' => 'load-message','ajax' => 'noAjax']) !!}
		</div>
	</div>

	<div class="clearfix"></div>
	{!!$message->body!!}
	@if($message->attachments)
		<p><i class="fa fa-paperclip"></i> <a href="/message/{{$message->token}}/download">{{$message->attachments}}</a></p>
	@endif

	@foreach($replies as $reply)
		<div style="border-bottom:1px solid #f5f5f5;margin: 15px 0px;"></div>
		<div style="margin-left:30px;" name="{{$reply->token}}">
		{!! getAvatar($reply->from_user_id,45) !!}
		<div style="float:left;margin-left:10px;margin-bottom: 20px;">
			<strong class="primary-font">{{$reply->UserFrom->full_name}}</strong> 
			<a href="#" data-source="/message/starred" data-extra="&token={{$reply->token}}"  data-ajax="1" data-refresh="load-message">
				@if((Auth::user()->id == $reply->from_user_id && $reply->is_starred_sender) || (Auth::user()->id == $reply->to_user_id && $reply->is_starred_receiver))
					<i class="fa fa-star fa-lg starred"></i>
				@else
					<i class="fa fa-star-o fa-lg starred"></i>
				@endif
			</a>	
			<br />
			{{showDateTime($reply->created_at)}}
		</div>
		<div class="pull-right">
			<div class="btn-group btn-group-xs">
				<a href="#" data-href="/message/forward/{{$reply->token}}" data-target="#myModal" data-toggle="modal" class="btn btn-default btn-xs">
					<i class="fa fa-share"></i>
				</a>
				{!! delete_form(['message.trash',$reply->id],['refresh' => 'load-message']) !!}
			</div>
		</div>
		<div class="clearfix"></div>
		{!!$reply->body!!}
		@if($reply->attachments)
			<p><i class="fa fa-paperclip"></i> <a href="/message/{{$reply->token}}/download">{{$reply->attachments}}</a></p>
		@endif
		</div>
	@endforeach