<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
    </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome to Eden+ System.</span>
            </li>

            @if(Entrust::can('manage-backup') && config('config.enable_backup'))
                <li><a href="{{url('backup')}}"><i class="fa fa-database fa-lg icon" data-toggle="tooltip" data-placement="left" title="{{trans('messages.backup')}}"></i></a></li>
            @endif

            @if(Entrust::can('manage-configuration'))
            <li><a href="{{url('configuration')}}"><i class="fa fa-cogs fa-lg icon" data-toggle="tooltip" data-placement="left" title="{{trans('messages.configuration')}}"></i></a></li>
            @endif

            @if(Entrust::can('manage-todo') && config('config.enable_to_do'))
            <li><a href="#" data-href="{{url('/todo')}}" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-list-ul fa-lg icon" data-toggle="tooltip" data-placement="left" title="{!! trans('messages.to_do') !!}" data-placement="bottom"></i></a></li>
            @endif

            @if(config('config.multilingual') && Entrust::can('change-language'))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-language fa-lg icon" data-toggle="tooltip" title="{!! trans('messages.language') !!}" data-placement="left"></i> </a>
                <ul class="dropdown-menu animated half flipInX">
                    <li class="active"><a href="#" style="color:white;cursor:default;">{!! config('lang.'.$default_language.'.language').' ('.$default_language.')' !!}</a></li>
                    @foreach(config('lang') as $key => $language)
                        @if($default_language != $key)
                        <li><a href="{{url('set-language/'.$key)}}">{!! $language['language']." (".$key.")" !!}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @endif
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw" data-toggle="tooltip" title="{!! trans('messages.profile') !!}" data-placement="left"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#" data-href="{{url('change-password')}}" data-toggle="modal" data-target="#myModal"><i class="fa fa-key fa-fw"></i> {!! trans('messages.change').' '.trans('messages.password') !!}</a></li>
                    @if(config('code.mode') && defaultRole())
                        <li><a href="#" data-href="/check-update" data-toggle='modal' data-target='#myModal'><i class="fa fa-search fa-fw"></i> {!! trans('messages.check').' '.trans('messages.update') !!}</a></li>
                        <li><a href="/release-license"><i class="fa fa-hand-spock-o fa-fw"></i> {!! trans('messages.release_license') !!}</a></li>
                    @endif
                    <li><a href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> {!! trans('messages.logout') !!}</a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
        </ul>

    </nav>