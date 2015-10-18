@extends('layouts.master')

@section('title')
	{{ $category->name_es }} {{ $brand->name }}
@stop

@section('content')
	<div ng-app="products">

		@include('products/search_form')
		
		@include('products/img_modal')
		@include('products/query_modal')

		@if ($data['result_count']['total'] > 0)
			<div ng-controller="ProductSearchResultsController" ng-init='init(<?php echo $data_json; ?>)'>
				<p class="well well-sm">
					Mostrando {{ $data['result_count']['from'] }}-{{ $data['result_count']['to'] }} de <strong>{{ $data['result_count']['total'] }}</strong> resultados.
				</p>		

				<div id="product-results">
					@foreach ($data['results'] as $item)			
						<div class="row row-no-sidemargin">
							<div class="col-md-2 text-center">
								@if (count($item->images))
									<img class="img-responsive cursor-pointer" src="/images/products/{{ $item->images[0]->filename }}" alt="{{ $item->descripcion_es }}" ng-click="openModal($event, <?php echo $loop->index; ?>)" />
								@else
									<img class="img-responsive" src="/images/products/noImage.jpg" alt="{{ $item->descripcion_es }}" />
								@endif
							</div>
							<div class="col-md-5">			
								<div class="product-code">{{ $item->code }}</div>
								<div class="product-name">{{ $item->name_es }}</div>
								<div><span class="label label-{{ @$item->material->class }}">{{ @$item->material->name_es }}</span></div>
							</div>
							<div class="col-md-2 product-price">			
								ARS {{ number_format($item->price_ars, 2) }}
							</div>
							<div class="col-md-3 text-center">
								<button class="btn btn-success" ng-click="openQueryModal($event, <?php echo $loop->index; ?>)">
									@lang('Consultar por este producto')
								</button>
							</div>
						</div>
					@endforeach		
				</div>
				
				<div class="text-center">
					{!! $data['results']->render() !!}
				</div>			
							
			</div>

		@else

			<p class="alert alert-danger">
				@lang('Lo sentimos, su búsqueda no produjo resultados.')
			</p>

		@endif
			
	</div>
@stop

@section('scripts')
	@parent
	{!! HTML::script('js/products.js') !!}	
@stop
