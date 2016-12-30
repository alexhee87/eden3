@extends('layouts.default')

@section('breadcrumb')
	<div class="row">
		<ul class="breadcrumb">
			<li><a href="{{url('home')}}">{!! trans('messages.home') !!}</a></li>
			<li class="active">{!! trans('messages.custom').' '.trans('messages.field') !!}</li>
		</ul>
	</div>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.company') !!}
				</div>
				<div class="panel-body">
					{!! Form::open(['route' => 'company.create','role' => 'form', 'class'=>'company-form','id' => 'company-form','data-disable-enter-submission' => '1']) !!}

					<div class="form-group">
						{!! Form::label('name',trans('messages.name'),[]) !!}
						{!! Form::input('text','name','',['class'=>'form-control','placeholder'=>trans('messages.name')]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('description',trans('messages.description'),[]) !!}
						{!! Form::input('textarea','description','',['class'=>'form-control','placeholder'=>trans('messages.description')]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('form',trans('messages.country'),[])!!}
						{!! Form::select('country_id', $countriesList,'',['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one')])!!}
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
					<strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.company') !!}
				</div>
				<div class="panel-body full">
					@include('common.datatable',['table' => $table_data['company-table']])
				</div>
			</div>
		</div>
	</div>
@stop