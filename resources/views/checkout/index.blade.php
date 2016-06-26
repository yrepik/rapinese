@extends('layouts.master')

@section('content')
    <div class="alert alert-{{ $cssClass }}">
        {{ $text }}
    </div>
@stop