@extends('layouts.default')

	@section('breadcrumb')
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
			    <li class="active">IP {!! trans('messages.filter') !!}</li>
			</ul>
        </div>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-lg-4">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{!!trans('messages.add_new').'</strong> IP '.trans('messages.filter')!!}
                    </div>
                    <div class="panel-body">
                    {!! Form::open(['route' => 'ip-filter.store','role' => 'form', 'class'=>'ip-filter-form','id' => 'ip-filter-form']) !!}
						@include('ip_filter._form')
					{!! Form::close() !!}
                    </div>
                </div>
			</div>
			<div class="col-lg-8">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{!!trans('messages.list_all').'</strong> IP '.trans('messages.filter')!!}
                    </div>
                    <div class="panel-body full">
						@include('common.datatable',['table' => $table_data['ip-filter-table']])
                    </div>
                </div>
			</div>
		</div>
	@stop