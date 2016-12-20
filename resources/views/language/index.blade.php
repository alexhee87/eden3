@extends('layouts.default')

	@section('breadcrumb')
        <div class="row">
			<ul class="breadcrumb">
			    <li><a href="{{url('home')}}">{!! trans('messages.home') !!}</a></li>
			    <li class="active">{!! trans('messages.language') !!}</li>
			</ul>
		</div>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-sm-4">
				<div class="panel panel-default">
                    <div class="panel-heading">
					<strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.language') !!}
					</div>
					<div class="panel-body">
						{!! Form::open(['route' => 'language.store','role' => 'form', 'class'=>'language-form','id' => 'language-form']) !!}
							@include('language._form')
						{!! Form::close() !!}
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="panel panel-default">
                    <div class="panel-heading">
						<strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.language') !!}
					</div>
					<div class="panel-body full">
						@include('common.datatable',['table' => $table_data['language-table']])
					</div>
				</div>
			</div>
		</div>
	@stop