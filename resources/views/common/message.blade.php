@if(!getMode())
	@include('common.notification',['message' => 'You are free to perform all actions. The demo gets reset in every 30 minutes.' ,'type' => 'danger'])
@endif