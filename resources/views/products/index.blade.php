@extends('layouts.master')

@section('content')
	<div ng-app="products">
        <h1>@lang('Buscador de productos')</h1>
		@include('products/search_form')
	</div>
@stop

@push('scripts')
	{!! HTML::script('js/products.js') !!}
@endpush
