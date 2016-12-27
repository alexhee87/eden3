@extends('layouts.default')

	@section('breadcrumb')
		<div class="row">
			<ul class="breadcrumb">
			    <li><a href="{{url('home')}}">{!! trans('messages.home') !!}</a></li>
			    <li class="active">Message</li>
			</ul>
		</div>
	@stop
	
	@section('content')
		<div class="row">
			<div class="tabs-container">
				<div class="tabs-left">
					<ul class="nav nav-tabs">
					  <li><a href="#compose-tab" data-toggle="tab"><i class="fa fa-pencil-square"></i> Compose</a></li>
					  <li class="active"><a href="#inbox-tab" data-toggle="tab"><i class="fa fa-inbox"></i> Inbox <span class="label label-warning pull-right">{{$count_inbox}}</span></a></li>
					  <li><a href="#sent-tab" data-toggle="tab"><i class="fa fa-share"></i> Sent</a></li>
					  <li><a href="#starred-tab" data-toggle="tab"><i class="fa fa-star"></i> Starred</a></li>
					  <li><a href="#trash-tab" data-toggle="tab"><i class="fa fa-trash"></i> Trash</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="inbox-tab">
							<div class="panel-body">
								<div class="full">
									@include('common.datatable',['table' => $table_data['inbox-table']])
								</div>
							</div>
						</div>
						<div class="tab-pane" id="sent-tab">
							<div class="panel-body">
								<div class="full">
									@include('common.datatable',['table' => $table_data['sent-table']])
								</div>
							</div>
						</div>
						<div class="tab-pane" id="starred-tab">
							<div class="panel-body">
								<div class="full">
									@include('common.datatable',['table' => $table_data['starred-table']])
								</div>
							</div>
						</div>
						<div class="tab-pane" id="trash-tab">
							<div class="panel-body">
								<div class="full">
									@include('common.datatable',['table' => $table_data['trash-table']])
								</div>
							</div>
						</div>
						<div class="tab-pane" id="compose-tab">
							<div class="panel-body">
								<div class="full">
									{!! Form::open(['files'=>'true','route' => 'message.store','role' => 'form', 'class'=>'compose-form','id' => 'compose-form','data-submit' => 'noAjax']) !!}
										<div class="form-group">
											{!! Form::select('to_user_id', $users, '',['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;'])!!}
										</div>
										<div class="form-group">
											{!! Form::input('text','subject','',['class'=>'form-control','placeholder'=>trans('messages.subject')])!!}
										</div>
										<div class="form-group">
											{!! Form::textarea('body','',['class' => 'form-control summernote', 'placeholder' => trans('messages.body')])!!}
										</div>
										<div class="form-group">
											<input type="file" name="file" id="file" class="fileinput" title="{!! trans('messages.select').' '.trans('messages.attachment') !!}">
										</div>
										<div class="form-group">
											<div class="pull-right">
												<button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-paper-plane"></i> {!! trans('messages.send') !!}</button>
											</div>
										</div>
									{!! Form::close() !!}
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    @stop