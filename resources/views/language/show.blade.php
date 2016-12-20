@extends('layouts.default')

	@section('breadcrumb')
		<div class="row">
			<ul class="breadcrumb">
			    <li><a href="{{url('home')}}">{!! trans('messages.home') !!}</a></li>
			    <li><a href="{{url('language')}}">{!! trans('messages.language') !!}</a></li>
			    <li class="active">{!! config('lang.'.$locale.'.language') !!}</li>
			</ul>
		</div>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-xs-2">
			    <ul class="nav nav-tabs tabs-left">
			      <li class="active"><a href="#add-new" data-toggle="tab">{{trans('messages.add_new').' '.trans('messages.word')}}</a></li>
			      @foreach($modules as $module)
				  	<li><a href="#_{{ $module }}" data-toggle="tab"> {!! trans('messages.'.$module) !!} ({{ $word_count[$module] }})</a></li>
				  @endforeach
			    </ul>
			</div>
			<div class="col-xs-10">
			    <div class="tab-content">
			      	<div class="tab-pane active" id="add-new">
						<div class="panel panel-default">
							<div class="panel-heading">
                    			<strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.word_for_translation') !!}
                    		</div>
                    		<div class="panel-body">
								{!! Form::open(['route' => 'language.add-words','role' => 'form', 'class'=>'language-entry-form','id' => 'language-entry-form','data-submit' => 'noAjax']) !!}
								  
						  		  <div class="form-group">
								    {!! Form::label('text',trans('messages.key'),[])!!}
									{!! Form::input('text','key','',['class'=>'form-control','placeholder'=>trans('messages.key')])!!}
								  </div>
						  		  <div class="form-group">
								    {!! Form::label('text',trans('messages.word_or_sentence'),[])!!}
									{!! Form::input('text','text','',['class'=>'form-control','placeholder'=>trans('messages.word_or_sentence')])!!}
								  </div>
						  		  <div class="form-group">
								    {!! Form::label('module',trans('messages.module'),[])!!}
									{!! Form::input('text','module','',['class'=>'form-control','placeholder'=>trans('messages.module')])!!}
								  </div>
								{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary']) !!}
								{!! Form::close() !!}
                    		</div>
                    	</div>
                    </div>
			      @foreach($modules as $module)
					<div class="tab-pane" id="_{{ $module }}">
						<div class="panel panel-default">
                    		<div class="panel-heading">
                    			<strong>{{ trans('messages.'.$module) }}</strong> {{ trans('messages.translation') }}
                    		</div>
                    		<div class="panel-body">
					    		{!! Form::model($language,['method' => 'PATCH','route' => ['language.update-translation',$locale] ,'class' => 'form-horizontal','id'=>'language_translation_'.$module, 'data-no-form-clear' => 1]) !!}
								@foreach($words as $key => $word)
									@if($word['module'] == $module)
									<div class="form-group">
								    	{!! Form::label($key,$word['value'],['class'=>'col-sm-6 control-label pull-left'])!!}
										<div class="col-sm-6">
											@if($locale == 'en')
											{!! Form::input('text',$key,(array_key_exists($key, $translation)) ? $translation[$key] : $word['value'],['class'=>'form-control','placeholder'=>trans('messages.translation')])!!}
											@else
											{!! Form::input('text',$key,(array_key_exists($key, $translation)) ? $translation[$key] : '',['class'=>'form-control','placeholder'=>trans('messages.translation')])!!}
											@endif
										</div>
								  	</div>
								  	@endif
								@endforeach
								{!! Form::hidden('module',$module) !!}
								{!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
								{!! Form::close() !!}
                    		</div>
                    	</div>
					</div>
				  @endforeach
			    </div>
			</div>  
		</div>

	@stop