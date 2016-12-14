			<div class="col-sm-6">
			  <div class="form-group">
			    <?php echo Form::label('company_name',trans('messages.company').' '.trans('messages.name'),[]); ?>

				<?php echo Form::input('text','company_name',(config('config.company_name')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.company').' '.trans('messages.name')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('contact_person',trans('messages.contact').' '.trans('messages.person'),[]); ?>

				<?php echo Form::input('text','contact_person',(config('config.contact_person')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.contact').' '.trans('messages.person')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('email',trans('messages.email'),[]); ?>

				<?php echo Form::input('text','email',(config('config.email')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.email')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('phone',trans('messages.phone'),[]); ?>

				<?php echo Form::input('text','phone',(config('config.phone')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.phone')]); ?>

			  </div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
				    <?php echo Form::label('address',trans('messages.address'),[]); ?>

					<?php echo Form::input('text','address_1',(config('config.address_1')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.address_line_1')]); ?>

					<br />
					<?php echo Form::input('text','address_2',(config('config.address_2')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.address_line_2')]); ?>

					<br />
					<div class="row">
						<div class="col-xs-5">
						<?php echo Form::input('text','city',(config('config.city')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.city')]); ?>

						</div>
						<div class="col-xs-4">
						<?php echo Form::input('text','state',(config('config.state')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.state')]); ?>

						</div>
						<div class="col-xs-3">
						<?php echo Form::input('text','zipcode',(config('config.zipcode')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.zipcode')]); ?>

						</div>
					</div>
					<br />
					<?php echo Form::select('country_id', config('country'),(config('config.country_id')) ? : '',['class'=>'form-control select2me','placeholder'=>trans('messages.country')]); ?>

				</div>
			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

			</div>
