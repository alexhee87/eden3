@extends('layouts.default')

@section('breadcrumb')
	<div class="row">
		<ul class="breadcrumb">
			<li><a href="/home">{!! trans('messages.home') !!}</a></li>
			<li class="active">{!! trans('messages.custom').' '.trans('messages.field') !!}</li>
		</ul>
	</div>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.custom').' '.trans('messages.field') !!}
				</div>
				<div class="panel-body">
					{!! Form::open(['route' => 'custom-field.store','role' => 'form', 'class'=>'custom-field-form','id' => 'custom-field-form','data-disable-enter-submission' => '1']) !!}
					<div class="form-group">
						{!! Form::label('form',trans('messages.form'),[])!!}
						{!! Form::select('form', config('custom_field'),'',['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one')])!!}
					</div>
					<div class="form-group">
						{!! Form::label('title',trans('messages.title'),[])!!}
						{!! Form::input('text','title','',['class'=>'form-control','placeholder'=>trans('messages.title')])!!}
					</div>
					<div class="form-group">
						Required
						<div class="switch">
							<div class="onoffswitch">
								<input name="is_required" type="checkbox" checked class="onoffswitch-checkbox" id="is_required">
								<label class="onoffswitch-label" for="is_required">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('type',trans('messages.type'),[])!!}
						{!! Form::select('type', [
                        'text' => 'Text Box',
                        'number' => 'Number',
                        'email' => 'Email',
                        'url' => 'URL',
                        'date' => 'Date',
                        'select' => 'Select Box',
                        'radio' => 'Radio Button',
                        'checkbox' => 'Check Box',
                        'textarea' => 'Textarea'
                        ],'',['id' => 'type', 'class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one')])!!}
					</div>
					<div class="custom-field-option">
						{!! Form::label('options',trans('messages.option'),[]) !!}
						{!! Form::input('text','options','',['class'=>'tagsinput form-control','placeholder'=>'','size'=>'1','data-role' => 'tagsinput']) !!}

					</div>
					{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.custom').' '.trans('messages.field') !!}
				</div>
				<div class="panel-body full">
					@include('common.datatable',['table' => $table_data['custom-field-table']])
				</div>
			</div>
		</div>
	</div>
@stop