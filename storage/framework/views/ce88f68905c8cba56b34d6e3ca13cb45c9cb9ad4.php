		  <div class="form-group">
		    <?php echo Form::label('category',trans('messages.category'),['class' => 'control-label']); ?>

		    <?php echo Form::select('category', $category, '',['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;']); ?>

		  </div>
		  <div class="form-group">
		    <?php echo Form::label('name',trans('messages.name'),[]); ?>

			<?php echo Form::input('text','name','',['class'=>'form-control','placeholder'=>trans('messages.name')]); ?>

		  </div>
		  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>