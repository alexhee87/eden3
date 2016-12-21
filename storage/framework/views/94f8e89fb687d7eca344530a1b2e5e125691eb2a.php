
			  <div class="form-group">
			    <?php echo Form::label('start',trans('messages.start'),[]); ?>

				<?php echo Form::input('text','start',isset($ip_filter->start) ? $ip_filter->start : '',['class'=>'form-control','placeholder'=>trans('messages.start')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('end',trans('messages.end'),[]); ?>

				<?php echo Form::input('text','end',isset($ip_filter->end) ? $ip_filter->end : '',['class'=>'form-control','placeholder'=>trans('messages.end')]); ?>

			  </div>
			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

