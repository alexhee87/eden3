@extends('layouts.default')

	@section('breadcrumb')
        <div class="row">
			<ul class="breadcrumb">
			    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
			    <li class="active">{!! trans('messages.template') !!}</li>
			</ul>
		</div>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-sm-12 collapse" id="box-detail">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.template') !!}
                    	<div class="additional-btn">
							<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
						</div>
                    </div>
                    <div class="panel-body">
                    	{!! Form::open(['route' => 'template.store','role' => 'form', 'class'=>'email-template-form','id' => 'email-template-form','data-form-table' => 'template_table']) !!}
							@include('template._form')
						{!! Form::close() !!}
                    </div>
                </div>
            </div>
			<div class="col-sm-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.template') !!}
                    	<div class="additional-btn">
                    		<a href="/email" class="btn btn-sm btn-primary">{{trans('messages.email').' '.trans('messages.log')}}</a>
							<a href="#" data-toggle="collapse" data-target="#box-detail"><button class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i> {!! trans('messages.add_new') !!}</button></a>
						</div>
                    </div>
                    <div class="panel-body full">
						@include('common.datatable',['table' => $table_data['template-table']])
                    </div>
                </div>
            </div>
		</div>
	@stop