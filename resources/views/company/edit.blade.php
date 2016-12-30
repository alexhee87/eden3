
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.company') !!}</h4>
</div>
<div class="modal-body">
    {!! Form::model($company,['method' => 'PATCH','route' => ['company.update',$company->id] ,'class' => 'company-form','id' => 'company-form-edit']) !!}
        @include('company._form', ['buttonText' => trans('messages.update')])
    {!! Form::close() !!}
    <div class="clearfix"></div>
</div>