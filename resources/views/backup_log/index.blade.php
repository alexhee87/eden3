@extends('layouts.default')

	@section('breadcrumb')
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
			    <li class="active">{!! trans('messages.backup') !!}</li>
			</ul>
        </div>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{!!trans('messages.list_all').'</strong> '.trans('messages.backup')!!}
                        <div class="additional-btn">
                        	{!! Form::open(['route' => 'backup.store','role' => 'form', 'class'=>'backup-form','id' => 'backup-form']) !!}
								<span style="font-size:12px;">{{trans('messages.delete').' '.trans('messages.old')}}</span> <input name="delete_old_backup" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> 
								{!! Form::submit(trans('messages.generate').' '.trans('messages.backup'),['class' => 'btn btn-primary btn-sm']) !!}
							{!! Form::close() !!}
                        </div>
                    </div>
                    <div class="panel-body full">
						@include('common.datatable',['table' => $table_data['backup-table']])
                    </div>
                </div>
			</div>
		</div>
	@stop