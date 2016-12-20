@extends('layouts.default')

	@section('breadcrumb')
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="{{url('home')}}">{!! trans('messages.home') !!}</a></li>
			    <li class="active">{!! trans('messages.permission') !!}</li>
			</ul>
        </div>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-lg-4">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{!!trans('messages.add_new').'</strong> '.trans('messages.permission')!!}
                    </div>
                    <div class="panel-body">
                    {!! Form::open(['route' => 'permission.store','role' => 'form', 'class'=>'permission-form','id' => 'permission-form','data-submit' => 'noAjax']) !!}
						@include('permission._form')
					{!! Form::close() !!}
                    </div>
                </div>
			</div>
			<div class="col-lg-8">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{!!trans('messages.list_all').'</strong> '.trans('messages.permission')!!}</strong>
                        <div class="additional-btn">
                        	<a href="{{url('save-permission')}}" class="btn btn-primary btn-sm">{{trans('messages.permission_edit_roles')}}</a>
                        </div>
                    </div>
                    <div class="panel-body full">
                        @include('common.datatable',['table' => $table_data['permission-table']])
                    </div>
                </div>
			</div>
		</div>
	@stop