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
					<strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.team') !!}
				</div>
				<div class="panel-body">
					{!! Form::open(['route' => 'team.create','role' => 'form', 'class'=>'team-form','id' => 'team-form','data-disable-enter-submission' => '1']) !!}
					@include('team._form')
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.team') !!}
				</div>
				<div class="panel-body full">
					@include('common.datatable',['table' => $table_data['team-table']])
				</div>
			</div>
		</div>
	</div>
@stop