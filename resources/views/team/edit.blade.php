
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.team') !!}</h4>
</div>
<div class="modal-body">
    {!! Form::model($team,['method' => 'PATCH','route' => ['team.update',$team->id] ,'class' => 'team-form','id' => 'team-form-edit']) !!}
        @include('team._form', ['buttonText' => trans('messages.update')])
    {!! Form::close() !!}
    <div class="clearfix"></div>
</div>