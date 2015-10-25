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
					@lang('wells.products.search.results', ['from' => $data['result_count']['from'], 'to' => $data['result_count']['to'], 'total' => $data['result_count']['total']])
				</p>		

				<div id="product-results">
					@foreach ($data['results'] as $item)			
						<div class="row row-no-sidemargin">
							<div class="col-md-2 col-sm-3 text-center">
								@if (count($item->images))
									<a href="#" ng-click="openModal($event, <?php echo $loop->index; ?>)" class="img">
            							<span class="product-hover"><i class="fa fa-4x fa-search-plus"></i></span>
										<img class="img-responsive" src="/images/products/sm/{{ $item->images[0]->filename }}" alt="{{ $item->descripcion_es }}" />
									</a>									
								@else
									<img class="img-responsive" src="/images/products/noImage.jpg" alt="{{ $item->name_es }}" />
								@endif
							</div>
							<div class="col-md-5 col-sm-4">			
								<div class="product-code">{{ $item->code }}</div>
								<div class="product-name">{{ $item->name_es }}</div>
								<div><span class="label label-{{ @$item->material->class }}">{{ @$item->material->name_es }}</span></div>
							</div>
							<div class="col-md-2 col-sm-1 product-price">			
								{{ config('app.currency') }} {{ number_format($item->price_ars, 2) }}
							</div>
							<div class="col-md-3 col-sm-4 text-center">
								<button class="btn btn-success" ng-click="openQueryModal($event, <?php echo $loop->index; ?>)">
									@lang('buttons.products.ask')
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
				@lang('alerts.products.search.no_results')
			</p>

		@endif
			
	</div>
@stop

@section('scripts')
	@parent
	{!! HTML::script('js/products.js') !!}	
@stop
