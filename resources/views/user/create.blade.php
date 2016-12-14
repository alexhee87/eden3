@extends('layouts.default')

	@section('breadcrumb')
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
			    <li><a href="/user">{!! trans('messages.user') !!}</a></li>
			    <li class="active">{!! trans('messages.add_new').' '.trans('messages.user') !!}</li>
			</ul>
        </div>
		
	@stop
	
	@section('content')
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>{{trans('messages.add_new')}}</strong> {{trans('messages.user')}}
                    	<div class="additional-btn">
                    		<a href="#" data-href="/user" class="btn btn-sm btn-primary">{{trans('messages.list_all')}}</a>
                    	</div>
                    </div>
                    <div class="panel-body">
                    	{!! Form::open(['route' => 'user.store','role' => 'form', 'class' => 'user-form','id' => "user-form"]) !!}
						@include('auth._register_form')
						<div class="form-group">
							{!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
						</div>
						{!! Form::close() !!}
                    </div>
                </div>
            </div>
		</div>
	@stop