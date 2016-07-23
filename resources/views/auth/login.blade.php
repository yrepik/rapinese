@extends('layouts.master')

@section('title')
    @lang('titles.login')
@stop

@section('content')

    @if ($show_warning)
        <div class="alert alert-warning">@lang('alerts.auth.login_required')</div>
    @endif

    @if (count($errors))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            @lang('alerts.auth.invalid_credentials')
        </div>
    @endif

    {!! Form::open(['action' => ['Auth\AuthController@postLogin'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form-group">
            {!! Form::label('email', trans('labels.auth.email'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('email', null, ['id' => 'email', 'class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('password', trans('labels.auth.password'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::password('password', ['id' => 'password', 'class' => 'form-control']) !!}
                <p class="mt20">
                    <a href="">@lang('Olvidé mi contrasena')</a>
                </p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('remember') }} @lang('labels.auth.remember')
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary btn-lg">@lang('buttons.auth.login')</button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <a href="">@lang('Registrarme')</a>
            </div>
        </div>        
    {!! Form::close() !!}

@stop
