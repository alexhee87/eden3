@extends('layouts.default')

    @section('breadcrumb')
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="{{url('home')}}">{!! trans('messages.home') !!}</a></li>
			    <li class="active">Terms & Conditions</li>
			</ul>
        </div>
	@stop

    @section('content')
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Terms & Conditions</strong></div>
                    <div class="panel-body full">
                        Terms & Conditions
                    </div>
                </div>
            </div>
		</div>
    @stop