
    <div class="form-group">
        {!! Form::label('name',trans('messages.name'),[]) !!}
        {!! Form::input('text', 'name', isset($team->name) ? $team->name : '', ['class'=>'form-control','placeholder'=>trans('messages.name')]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('description', trans('messages.description'),[]) !!}
        {!! Form::input('textarea', 'description', isset($team->description) ? $team->description : '', ['class'=>'form-control','placeholder'=>trans('messages.description')]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('form', trans('messages.department'),[])!!}
        {!! Form::select('department_id', $departmentsList, isset($team->department_id) ? $team->department_id : '', ['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one')])!!}
    </div>
    {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'), ['class' => 'btn btn-primary pull-right']) !!}