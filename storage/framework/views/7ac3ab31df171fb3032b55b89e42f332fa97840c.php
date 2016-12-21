			<div class="col-sm-6">
			  <div class="form-group">
			    <?php echo Form::label('nexmo_api_key','Nexmo API Key',[]); ?>

				<?php echo Form::input('text','nexmo_api_key',config('config.nexmo_api_key') ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'API Key']); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('nexmo_api_secret','Nexmo API Secret',[]); ?>

				<?php echo Form::input('text','nexmo_api_secret',config('config.nexmo_api_secret') ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'API Secret']); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('nexmo_from_number','Nexmo From Number',[]); ?>

				<?php echo Form::input('text','nexmo_from_number',config('config.nexmo_from_number') ? : '',['class'=>'form-control','placeholder'=>'From Number']); ?>

			  </div>
			  <?php echo Form::hidden('config_type','sms'); ?>

			<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary']); ?>

			</div>
			<div class="clear"></div>
