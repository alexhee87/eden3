@extends('layouts.default')

	@section('breadcrumb')
		<div class="row">
			<ul class="breadcrumb">
			    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
			    <li class="active">{!! trans('messages.email').' '.trans('messages.log') !!}</li>
			</ul>
		</div>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
						<strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.email').' '.trans('messages.log') !!}
					</div>
					<div class="panel-body full">
						@include('common.datatable',['table' => $table_data['email-table']])
					</div>
				</div>
			</div>
		</div>

	@stop