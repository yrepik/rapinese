<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>RAPINESE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="." />
        <link media="all" type="text/css" rel="stylesheet" href="/css/lib.css" />
    </head>
    <body style="padding-top: 50px;">

        <div class="container">

            <div class="panel panel-default">
                <div class="panel-heading">Acceso Administrador</div>
                <div class="panel-body">

                    @include('admin.errors')
                    @include('admin.success')

                    {!! Form::open(['action' => ['Admin\Auth\AuthController@postLogin'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            {!! Form::label('username', trans('labels.username'), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('username', null, ['id' => 'email', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', trans('labels.password'), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', ['id' => 'password', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('remember') }} @lang('labels.remember')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-lg">@lang('buttons.login')</button>
                            </div>
                        </div>
          
                    {!! Form::close() !!}
                </div>
            </div>
        </div>    
    
    </body>
</html>