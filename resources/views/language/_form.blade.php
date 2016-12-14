
			  <div class="form-group">
			    {!! Form::label('locale',trans('messages.locale'),[])!!}
			  	@if(!isset($locale))
					{!! Form::input('text','locale',isset($locale) ? $locale : '',['class'=>'form-control','placeholder'=>trans('messages.locale')])!!}
				@else
					{!! Form::input('text','locale',isset($locale) ? $locale : '',['class'=>'form-control','placeholder'=>trans('messages.locale'),'readonly' => 'true'])!!}
				@endif	
			  </div>
			  <div class="form-group">
			    {!! Form::label('name',trans('messages.language').' '.trans('messages.name'),[])!!}
				{!! Form::input('text','name',isset($locale) ? config('lang.'.$locale.'.language') : '',['class'=>'form-control','placeholder'=>trans('messages.language').' '.trans('messages.name')])!!}
			  </div>
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary']) !!}
