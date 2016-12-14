@extends('layouts.default')

    @section('breadcrumb')
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header">Dashboard</h4>
            </div>
        </div>
    @stop

    @section('content')
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{\App\User::whereStatus('active')->count()}}</div>
                                <div>{{trans('messages.active').' '.trans('messages.user')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user-times fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{\App\User::whereStatus('banned')->count()}}</div>
                                <div>{{trans('messages.banned').' '.trans('messages.user')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{\App\User::whereStatus('pending_activation')->count()}}</div>
                                <div>{{trans('messages.pending').' '.trans('messages.activation')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user-plus fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{\App\User::whereStatus('pending_approval')->count()}}</div>
                                <div>{{trans('messages.pending').' '.trans('messages.approval')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        {{trans('messages.calendar')}}
                    </div>
                    <div class="panel-body">
                        <div id="render_calendar">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if(config('config.enable_group_chat'))
                <div class="panel panel-primary chat-panel">
                    <div class="panel-heading">
                        <strong>{{trans('messages.group')}}</strong> {{trans('messages.chat')}}
                    </div>
                    <div class="panel-body" id="chat-box">
                        <div id="chat-messages" data-chat-refresh="{{config('config.enable_chat_refresh')}}" data-chat-refresh-duration="{{ config('config.chat_refresh_duration') }}"></div>
                    </div>
                    <div class="panel-footer">
                    {!! Form::open(['route' => 'chat.store','role' => 'form', 'class'=>'chat-form','id' => 'chat-form','data-refresh' => 'chat-messages']) !!}
                    {!! Form::input('text','message','',['class'=>'form-control','data-autoresize' => 1,'placeholder' => 'Type your message here..'])!!}
                    {!! Form::close() !!}
                    </div>
                </div>
                @endif
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        {{trans('messages.celebration')}}
                    </div>
                    <div class="panel-body" style="max-height:350px;overflow-y:scroll;">
                        <ul class="media-list">
                        @foreach($celebrations as $celebration)
                          <li class="media">
                            <a class="pull-left" href="#">
                              {!! getAvatar($celebration['id'],55) !!}
                            </a>
                            <div class="media-body">
                              <p class="media-heading"><i class="fa fa-{{ $celebration['icon'] }} icon" style="margin-right:10px;"></i> {{ $celebration['title'] }} ({!! $celebration['number'] !!})</p>
                              <p style="margin-bottom:5px;"><strong>{!! $celebration['name'] !!}</strong></p>
                            </div>
                          </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @stop