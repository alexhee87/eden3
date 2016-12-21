			<div class="col-sm-6">
			  <div class="form-group">
			    <?php echo Form::label('driver','Driver',[]); ?>

				<?php echo Form::select('driver', [
					null=>'Please Select',
					'mail' => 'mail',
					'sendmail' => 'sendmail',
					'smtp' => 'smtp',
					'mailgun' => 'mailgun',
					'mandrill' => 'mandrill',
					'log' => 'log'
					],(config('mail.driver')) ? : '',['id' => 'mail_driver', 'class'=>'form-control input-xlarge select2me','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;']); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('from_address','From Address',[]); ?>

				<?php echo Form::input('email','from_address',config('mail.from.address') ? : '',['class'=>'form-control','placeholder'=>'From Address']); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('from_name','From Name',[]); ?>

				<?php echo Form::input('text','from_name',config('mail.from.name') ? : '',['class'=>'form-control','placeholder'=>'From Name']); ?>

			  </div>
			  <?php echo Form::hidden('config_type','mail'); ?>

			<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary']); ?>

			</div>
			<div class="col-sm-6">
				<div id="smtp_configuration" class="mail_config">
				  <div class="form-group">
				    <?php echo Form::label('host','SMTP Host',[]); ?>

					<?php echo Form::input('text','host',(config('mail.host')) ? : '',['class'=>'form-control','placeholder'=>'SMTP Host']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('port','SMTP Port',[]); ?>

					<?php echo Form::input('text','port',(config('mail.port')) ? : '',['class'=>'form-control','placeholder'=>'SMTP Port']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('username','SMTP Username',[]); ?>

					<?php echo Form::input('text','username',(config('mail.username')) ? : '',['class'=>'form-control','placeholder'=>'SMTP Username']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('password','SMTP Password',[]); ?>

					<?php echo Form::input('password','password',(config('mail.password')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'SMTP Password']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('encryption','Encryption',[]); ?>

					<?php echo Form::select('encryption', ['ssl'=>'SSL',
					'tls' => 'TLS'],(config('config.encryption')) ? : 'tls',['class'=>'form-control select2me','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;']); ?>

				  </div>
				</div>
				<div id="mandrill_configuration" class="mail_config">
				  <div class="form-group">
				    <?php echo Form::label('mandrill_secret','Secret Key',[]); ?>

					<?php echo Form::input('text','mandrill_secret',(config('services.mandrill.secret')) ? : '',['class'=>'form-control','placeholder'=>'Secret Key']); ?>

				  </div>
				</div>
				<div id="mailgun_configuration" class="mail_config">
				  <div class="form-group">
				    <?php echo Form::label('mailgun_domain','Domain',[]); ?>

					<?php echo Form::input('text','mailgun_domain',(config('services.mailgun.domain')) ? : '',['class'=>'form-control','placeholder'=>'Domain']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('mailgun_secret','Secret Key',[]); ?>

					<?php echo Form::input('text','mailgun_secret',(config('services.mailgun.secret')) ? : '',['class'=>'form-control','placeholder'=>'Secret Key']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('mailgun_host','SMTP Host',[]); ?>

					<?php echo Form::input('text','mailgun_host',(config('mail.host')) ? : '',['class'=>'form-control','placeholder'=>'SMTP Host']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('mailgun_port','SMTP Port',[]); ?>

					<?php echo Form::input('text','mailgun_port',(config('mail.port')) ? : '',['class'=>'form-control','placeholder'=>'SMTP Port']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('mailgun_username','STMP Username',[]); ?>

					<?php echo Form::input('text','mailgun_username',(config('mail.username')) ? : '',['class'=>'form-control','placeholder'=>'STMP Username']); ?>

				  </div>
				  <div class="form-group">
				    <?php echo Form::label('mailgun_password','STMP Password',[]); ?>

					<?php echo Form::input('text','mailgun_password',(config('mail.password')) ? : '',['class'=>'form-control','placeholder'=>'STMP Password']); ?>

				  </div>
				</div>
			</div>
			<div class="clear"></div>
