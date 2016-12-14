
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.language') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model('',['method' => 'PATCH','route' => ['language.update',$locale] ,'class' => 'language-form','id' => 'language-form-edit']) !!}
			@include('language._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
	<div class="modal-footer">
	</div>