@extends('layouts.default')

    @section('breadcrumb')
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
			    <li class="active">{!! trans('messages.permission') !!}</li>
			</ul>
        </div>
    @stop

    @section('content')
        <div class="row">
        	<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{!!trans('messages.save').'</strong> '.trans('messages.permission')!!}
                        <div class="additional-btn">
                        </div>
                    </div>
                    {!! Form::open(['route' => 'permission.save-permission','role' => 'form', 'class'=>'permission-form','id' => 'permission-form','data-no-form-clear' => 1]) !!}
                    <div class="panel-body full">
                    	<table class="table table-hover table-striped">
					  	<thead>
					  		<tr>
					  			<th>{!! trans('messages.permission') !!}</th>
					  			@foreach(\App\Role::all() as $role)
					  			<th>{!! toWord($role->name) !!}</th>
					  			@endforeach
					  		</tr>
					  		</tr>
					  	</thead>
					  	<tbody>
					  		@foreach($permissions as $permission)
					  			@if($permission->category != $category)
					  			<tr style="background-color:#3498DB;color:#ffffff;"><td colspan="{!! count(\App\Role::all())+1 !!} "><strong>{!! toWord($permission->category).' '.trans('messages.module') !!}</strong></td></tr>
					  			<?php $category = $permission->category; ?>
					  			@endif
					  			<tr>
					  				<td>{!! toWord($permission->name) !!}</td>
						  			@foreach(\App\Role::all() as $role)
						  			<th><input class="icheck" type="checkbox" name="permission[{!!$role->id!!}][{!!$permission->id!!}]" value = '1' {!! (in_array($role->id.'-'.$permission->id,$permission_role)) ? 'checked' : '' !!} @if($role->is_hidden) disabled @endif></th>
						  			@endforeach
					  			</tr>
					  		@endforeach
					  	</tbody>
					  </table>
					  {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right','style' => 'margin:10px;']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
			</div>
        </div>
    @stop