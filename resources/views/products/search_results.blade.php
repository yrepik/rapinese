@extends('layouts.master')

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
							<div class="col-md-2 col-sm-3 text-center">
								@if (count($item->images))
									<img class="img-responsive cursor-pointer" src="/images/productos/{{ $item->images[0]->filename }}" alt="{{ $item->descripcion_es }}" ng-click="openModal($event, <?php echo $loop->index; ?>)" />
								@else
									<img class="img-responsive" src="/images/productos/noImage.jpg" alt="{{ $item->descripcion_es }}" />
								@endif
							</div>
							<div class="col-md-5 col-sm-3">			
								<h6>{{ $item->code }}</h6>
								<h5>{{ $item->name_es }}</h5>
								<div>{{ @$item->material->name_es }}</div>
							</div>
							<div class="col-md-2 col-sm-2">			
								<h5>ARS {{ number_format($item->price_ars, 2) }}</h4>
							</div>
							<div class="col-md-3 col-sm-4 text-center">
								<button class="btn btn-success" ng-click="openQueryModal($event, <?php echo $loop->index; ?>)">
									Consultar por este producto
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
				Lo sentimos, su búsqueda no produjo resultados.
			</p>

		@endif
			
	</div>
@stop

@section('scripts')
	@parent
	{!! HTML::script('js/products.js') !!}	
@stop
