@extends('layouts.master')

@section('content')
    {!! Form::open(['role' => 'form', 'class' => '', 'novalidate']) !!}
        <div class="form-group">
            {!! Form::label('email', trans('labels.price_list.email')) !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-large btn-info">
                @lang('buttons.products.ask.send')
            </button>
        </div>        
    {!! Form::close() !!}
@stop
