<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    {!! getAvatar(Auth::user()->id,75) !!}
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear">
                        <span class="block m-t-xs">
                            <strong class="font-bold">{{ucfirst(Auth::user()->full_name)}}</strong>
                        </span>
                        <!-- title -->
                        <!--<span class="text-muted text-xs block">Art Director <b class="caret"></b></span>-->
                    </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="{{url('home')}}"><i class="fa fa-home fa-fw"></i> <span class="nav-label">{{trans('messages.home') }}</span></a>
            </li>

            @if(Entrust::can('manage-user') || Entrust::can('manage-role') || Entrust::can('manage-permissions'))
            <li class="user role permission">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">{{trans('messages.users_management') }}</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @if(Entrust::can('manage-user'))
                        <li id="user"><a href="{{url('user')}}"><i class="fa fa-users fa-fw"></i> {{trans('messages.user') }}</a></li>
                    @endif
                    @if(Entrust::can('manage-role'))
                        <li id="role"><a href="{{url('role')}}"><i class="fa fa-user fa-fw"></i> {{trans('messages.user').' '.trans('messages.role') }}</a></li>
                    @endif
                    @if(Entrust::can('manage-permission'))
                        <li id="permission"><a href="{{url('permission')}}"><i class="fa fa-lock fa-fw"></i> {{trans('messages.permission') }}</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if(Entrust::can('manage-custom-field') && config('config.enable_custom_field'))
                <li id="custom-field"><a href="{{url('custom-field')}}"><i class="fa fa-wrench fa-fw"></i>  <span class="nav-label">{{trans('messages.custom').' '.trans('messages.field') }}</span></a></li>
            @endif
            @if(Entrust::can('manage-language') && config('config.multilingual'))
                <li id="language"><a href="{{url('language')}}"><i class="fa fa-globe fa-fw"></i> <span class="nav-label">{{trans('messages.language') }}</span></a></li>
            @endif
            @if(Entrust::can('manage-template') && config('config.enable_email_template'))
                <li id="template"><a href="{{url('template')}}"><i class="fa fa-envelope fa-fw"></i>  <span class="nav-label">{{trans('messages.email').' '.trans('messages.template') }}</span></a></li>
            @endif
            @if(config('config.enable_activity_log'))
            <li id="activity-log"><a href="{{url('activity-log')}}"><i class="fa fa-bars fa-fw"></i>  <span class="nav-label">{{trans('messages.activity').' '.trans('messages.log') }}</span></a></li>
            @endif
            @if(Entrust::can('manage-message') && config('config.enable_message'))
            <li id="message"><a href="{{url('message')}}"><i class="fa fa-paper-plane fa-fw"></i>  <span class="nav-label">{{trans('messages.message') }}</span></a></li>
            @endif
            @if(Entrust::can('manage-ip-filter') && config('config.enable_ip_filter'))
                <li id="ip-filter"><a href="{{url('ip-filter')}}"><i class="fa fa-ellipsis-v fa-fw"></i>  <span class="nav-label">IP {{trans('messages.filter') }}</span></a></li>
            @endif

            <!-- Manage Entities -->
            @if(true || Entrust::can('manage-entities'))
            <li class="manage-entities department company location country">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">{{trans('messages.manage_entities') }}</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li id="country"><a href="{{url('country')}}"><i class="fa fa-flag fa-fw"></i> {{trans('messages.country') }}</a></li>
                    <li id="company"><a href="{{url('company')}}"><i class="fa fa-building-o fa-fw"></i> {{trans('messages.company') }}</a></li>
                    <li id="location"><a href="{{url('location')}}"><i class="fa fa-road fa-fw"></i> {{trans('messages.location') }}</a></li>
                    <li id="department"><a href="{{url('department')}}"><i class="fa fa-suitcase fa-fw"></i> {{trans('messages.department') }}</a></li>
                </ul>
            </li>
            @endif

        </ul>

    </div>
</nav>