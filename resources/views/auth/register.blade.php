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
                        <h3 class="panel-title"><strong>{!! trans('messages.user') !!}</strong> {!! trans('messages.registration') !!}</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ url('/user') }}" id="user-registration-form" >
                            {{ csrf_field() }}
                            <fieldset>
                                @include('auth._register_form')
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-block btn-success">{!! trans('messages.register') !!}</button>
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