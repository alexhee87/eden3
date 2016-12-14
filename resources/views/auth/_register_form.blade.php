
                                <label for="name">{{trans('messages.name')}}</label>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                             <input type="text" name="first_name" id="first_name" class="form-control" placeholder="{!! trans('messages.first').' '.trans('messages.name') !!}">
                                        </div>
                                        <div class="col-md-6">
                                             <input type="text" name="last_name" id="last_name" class="form-control" placeholder="{!! trans('messages.last').' '.trans('messages.name') !!}">
                                        </div>
                                    </div>
                                   
                                </div>
                                <label for="email">{{trans('messages.email')}}</label>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="{!! trans('messages.email') !!}">
                                </div>
                                @if(!config('config.login'))
                                <label for="email">{{trans('messages.username')}}</label>
                                <div class="form-group">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="{!! trans('messages.username') !!}">
                                </div>
                                @endif
                                <label for="email">{{trans('messages.password')}}</label>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control {{(config('config.enable_password_strength_meter') ? 'password-strength' : '')}}" placeholder="{!! trans('messages.password') !!}">
                                </div>
                                <label for="email">{{trans('messages.confirm').' '.trans('messages.password')}}</label>
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{!! trans('messages.confirm').' '.trans('messages.password') !!}">
                                </div>
                                {{ getCustomFields('user-registration-form') }}
                                @if(Auth::check())
                                <div class="form-group">
                                    <input name="send_welcome_email" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> {{trans('messages.send')}} welcome email
                                </div>
                                @endif
                                @if(config('config.enable_tnc'))
                                <div class="form-group">
                                    <input name="tnc" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> I accept <a href="/terms-and-conditions">Terms & Conditions</a>.
                                </div>
                                @endif
                                @if(config('config.enable_recaptcha') && !Auth::check())
                                <div class="g-recaptcha" data-sitekey="{{config('config.recaptcha_key')}}"></div>
                                <br />
                                @endif