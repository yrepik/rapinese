@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-3 text-center">
            <span class="rapinese-icon rapinese-icon-car-insurance" style="font-size: 260px;"></span>
		</div>
		<div class="col-md-9">
    		<h1>@yield('message')</h1>
		</div>
	</div>
@stop