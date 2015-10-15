@extends('layouts.master')

@section('content')
	<div ng-app="products">
		@include('products/search_form')	
	</div>
@stop

@section('scripts')
	@parent
	{!! HTML::script('js/products.js') !!}	
@stop
