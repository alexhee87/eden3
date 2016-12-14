<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <?php echo getAvatar(Auth::user()->id,75); ?>

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear">
                        <span class="block m-t-xs">
                            <strong class="font-bold"><?php echo e(ucfirst(Auth::user()->full_name)); ?></strong>
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
                <a href="/home"><i class="fa fa-home fa-fw"></i> <span class="nav-label"><?php echo e(trans('messages.home')); ?></span></a>
            </li>

            <?php if(Entrust::can('manage-user') || Entrust::can('manage-role') || Entrust::can('manage-permissions')): ?>
            <li class="user role permission">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo e(trans('messages.users_management')); ?></span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <?php if(Entrust::can('manage-user')): ?>
                        <li id="user"><a href="/user"><i class="fa fa-users fa-fw"></i> <?php echo e(trans('messages.user')); ?></a></li>
                    <?php endif; ?>
                    <?php if(Entrust::can('manage-role')): ?>
                        <li id="role"><a href="/role"><i class="fa fa-user fa-fw"></i> <?php echo e(trans('messages.user').' '.trans('messages.role')); ?></a></li>
                    <?php endif; ?>
                    <?php if(Entrust::can('manage-permission')): ?>
                        <li id="permission"><a href="/permission"><i class="fa fa-lock fa-fw"></i> <?php echo e(trans('messages.permission')); ?></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            <?php if(Entrust::can('manage-custom-field') && config('config.enable_custom_field')): ?>
                <li id="custom-field"><a href="/custom-field"><i class="fa fa-wrench fa-fw"></i>  <span class="nav-label"><?php echo e(trans('messages.custom').' '.trans('messages.field')); ?></span></a></li>
            <?php endif; ?>
            <?php if(Entrust::can('manage-language') && config('config.multilingual')): ?>
                <li id="language"><a href="/language"><i class="fa fa-globe fa-fw"></i> <span class="nav-label"><?php echo e(trans('messages.language')); ?></span></a></li>
            <?php endif; ?>
            <?php if(Entrust::can('manage-template') && config('config.enable_email_template')): ?>
                <li id="template"><a href="/template"><i class="fa fa-envelope fa-fw"></i>  <span class="nav-label"><?php echo e(trans('messages.email').' '.trans('messages.template')); ?></span></a></li>
            <?php endif; ?>
            <?php if(config('config.enable_activity_log')): ?>
            <li id="activity-log"><a href="/activity-log"><i class="fa fa-bars fa-fw"></i>  <span class="nav-label"><?php echo e(trans('messages.activity').' '.trans('messages.log')); ?></span></a></li>
            <?php endif; ?>
            <?php if(Entrust::can('manage-message') && config('config.enable_message')): ?>
            <li id="message"><a href="/message"><i class="fa fa-paper-plane fa-fw"></i>  <span class="nav-label"><?php echo e(trans('messages.message')); ?></span></a></li>
            <?php endif; ?>
            <?php if(Entrust::can('manage-ip-filter') && config('config.enable_ip_filter')): ?>
                <li id="ip-filter"><a href="/ip-filter"><i class="fa fa-ellipsis-v fa-fw"></i>  <span class="nav-label">IP <?php echo e(trans('messages.filter')); ?></span></a></li>
            <?php endif; ?>

        </ul>

    </div>
</nav>