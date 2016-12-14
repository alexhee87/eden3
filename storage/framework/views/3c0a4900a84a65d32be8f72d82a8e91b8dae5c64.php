
                                <label for="name"><?php echo e(trans('messages.name')); ?></label>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                             <input type="text" name="first_name" id="first_name" class="form-control" placeholder="<?php echo trans('messages.first').' '.trans('messages.name'); ?>">
                                        </div>
                                        <div class="col-md-6">
                                             <input type="text" name="last_name" id="last_name" class="form-control" placeholder="<?php echo trans('messages.last').' '.trans('messages.name'); ?>">
                                        </div>
                                    </div>
                                   
                                </div>
                                <label for="email"><?php echo e(trans('messages.email')); ?></label>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo trans('messages.email'); ?>">
                                </div>
                                <?php if(!config('config.login')): ?>
                                <label for="email"><?php echo e(trans('messages.username')); ?></label>
                                <div class="form-group">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo trans('messages.username'); ?>">
                                </div>
                                <?php endif; ?>
                                <label for="email"><?php echo e(trans('messages.password')); ?></label>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control <?php echo e((config('config.enable_password_strength_meter') ? 'password-strength' : '')); ?>" placeholder="<?php echo trans('messages.password'); ?>">
                                </div>
                                <label for="email"><?php echo e(trans('messages.confirm').' '.trans('messages.password')); ?></label>
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="<?php echo trans('messages.confirm').' '.trans('messages.password'); ?>">
                                </div>
                                <?php echo e(getCustomFields('user-registration-form')); ?>

                                <?php if(Auth::check()): ?>
                                <div class="form-group">
                                    <input name="send_welcome_email" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> <?php echo e(trans('messages.send')); ?> welcome email
                                </div>
                                <?php endif; ?>
                                <?php if(config('config.enable_tnc')): ?>
                                <div class="form-group">
                                    <input name="tnc" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> I accept <a href="/terms-and-conditions">Terms & Conditions</a>.
                                </div>
                                <?php endif; ?>
                                <?php if(config('config.enable_recaptcha') && !Auth::check()): ?>
                                <div class="g-recaptcha" data-sitekey="<?php echo e(config('config.recaptcha_key')); ?>"></div>
                                <br />
                                <?php endif; ?>