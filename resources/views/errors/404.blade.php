@extends('guest_layouts.default')

    @section('content')
    <div class="container">
        <div class="row">
            <div class="text-center">
                <h1>404 <i class="fa fa-meh-o"></i> </h1>
                <p>{!! trans('messages.page_not_found') !!}</p>
                <p>{!! trans('messages.back_to') !!} <a href="/">{!! trans('messages.home') !!}</a></p>
            </div>
        </div>
    </div>
    @stop