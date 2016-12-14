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
                        <h3 class="panel-title"><strong>{!! trans('messages.verify') !!}</strong> {!! trans('messages.purchase') !!}</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="{!! URL::to('/verify-purchase') !!}" method="post" class="verify-purchase-form" id="verify-purchase-form" data-submit="noAjax">
                        {!! csrf_field() !!}
                        <div class="form-group">
                        <input type="text" name="envato_username" id="envato_username" class="form-control text-input" placeholder="Envato Username">
                        </div>
                        <div class="form-group">
                        <input type="text" name="purchase_code" id="purchase_code" class="form-control text-input" placeholder="Purchase Code">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-unlock"></i> Verify</button>
                            </div>
                            <div class="col-sm-6">
                                <a href="/login" class="btn btn-block btn-info">{!! trans('messages.back_to').' '.trans('messages.login') !!}</a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="credit">{{config('config.credit')}}</div>
    </div>
    @stop