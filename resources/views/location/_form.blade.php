
    <div class="form-group">
        {!! Form::label('name',trans('messages.name'),[]) !!}
        {!! Form::input('text', 'name', isset($company->name) ? $company->name : '', ['class'=>'form-control','placeholder'=>trans('messages.name')]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('description', trans('messages.description'),[]) !!}
        {!! Form::input('textarea', 'description', isset($company->description) ? $company->description : '', ['class'=>'form-control','placeholder'=>trans('messages.description')]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('form', trans('messages.company'),[])!!}
        {!! Form::select('company_id', $companiesList, isset($company->company_id) ? $company->company_id : '', ['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one')])!!}
    </div>
    {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'), ['class' => 'btn btn-primary pull-right']) !!}