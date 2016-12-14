@extends('guest_layouts.default')

    @section('content')
    <div class="container">
        @if(config('config.logo') && File::exists(config('constant.upload_path.logo').config('config.logo')))
            <div class="logo text-center">
                <img src="/{!! config('constant.upload_path.logo').config('config.logo') !!}" class="logo-image" alt="Logo">
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>{!! trans('messages.forgot') !!}</strong> {!! trans('messages.password') !!}</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="{!! URL::to('/password/email') !!}" method="post" class="forgot-form" id="forgot-form" data-submit="noAjax">
                            {!! csrf_field() !!}
                            <fieldset>
                                <div class="form-group">
                                    <div class="input-group margin-bottom-sm">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="{!! trans('messages.email') !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-block btn-success">{!! trans('messages.reset').' '.trans('messages.password') !!}</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="/login" class="btn btn-block btn-info">{!! trans('messages.back_to').' '.trans('messages.login') !!}</a>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="credit">{{config('config.credit')}}</div>
    </div>
    @stop