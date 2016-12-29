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
					<strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.country') !!}
				</div>
				<div class="panel-body">
					{!! Form::open(['route' => 'country.store','role' => 'form', 'class'=>'country-form','id' => 'country-form','data-disable-enter-submission' => '1']) !!}
					<div class="form-group">
						{!! Form::label('form',trans('messages.country_name'),[])!!}
                        {!! Form::input('text','name','',['class'=>'form-control','placeholder'=>trans('messages.country_name')]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('title',trans('messages.title'),[]) !!}
						{!! Form::input('text','iso_name','',['class'=>'form-control','placeholder'=>trans('messages.country_iso')]) !!}
					</div>
                    {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.country') !!}
				</div>
				<div class="panel-body full">
					@include('common.datatable',['table' => $table_data['country-table']])
				</div>
			</div>
		</div>
	</div>
@stop