@extends('layouts.master')

@section('content')
	
	<div class="row">
		<div class="col-md-3 text-center">
			<img src="/images/404.png" class="img-responsive" style="max-height: 200px;" />
		</div>
		<div class="col-md-9">
    		<h1>@lang('La página solicitada no existe.')</h1>
		</div>
    
@stop