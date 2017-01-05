
    <div class="form-group">
        {!! Form::label('name',trans('messages.name'),[]) !!}
        {!! Form::input('text', 'name', isset($department->name) ? $department->name : '', ['class'=>'form-control','placeholder'=>trans('messages.name')]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('description', trans('messages.description'),[]) !!}
        {!! Form::input('textarea', 'description', isset($department->description) ? $department->description : '', ['class'=>'form-control','placeholder'=>trans('messages.description')]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('form', trans('messages.location'),[])!!}
        {!! Form::select('location_id', $locationsList, isset($department->location_id) ? $department->location_id : '', ['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one')])!!}
    </div>
    {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'), ['class' => 'btn btn-primary pull-right']) !!}