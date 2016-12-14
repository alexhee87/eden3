@extends('guest_layouts.default')

	@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Two Factor Auth</strong></h3>
                    </div>
                    <div class="panel-body">
						{!! Form::open(['route' => 'user.verify-security','role' => 'form', 'class'=>'two-factor-auth-form','id' => 'two-factor-auth-form','data-submit' => 'noAjax']) !!}
							<div class="row">
								<div class="col-md-2">
									{!! getAvatar(Auth::user()->id,80) !!}
								</div>
								<div class="col-md-10">
									<div class="form-group">
									    {!! Form::label('login',(config('config.login') ? Auth::user()->email : Auth::user()->username),[])!!}
										{!! Form::input('text','two_factor_auth',(!getMode()) ? session('two_factor_auth') : '',['class'=>'form-control','placeholder'=>'Two Factor Auth'])!!}
									</div>
									{!! Form::submit(trans('messages.verify'),['class' => 'btn btn-primary']) !!}
									<a href="#" class="btn btn-danger" onclick="event.preventDefault();
                            			document.getElementById('logout-form').submit();">Not {{Auth::user()->full_name}}? Logout?</a>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	@stop