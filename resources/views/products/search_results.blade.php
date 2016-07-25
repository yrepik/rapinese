@extends('layouts.master')

@section('title')
	{{ $category->name_es }} {{ $brand->name }}
@stop

@section('content')
	<div ng-app="products">
		<h1>@lang('headers.products')</h1>
		@include('products.search_form')

		<ol class="breadcrumb visible-print-block">
			<li>{{ $brand->name }}</li>
	  		<li>{{ $category->name_es }}</li>	  		
		</ol>		
		
		@include('products.img_modal')
		@include('products.query_modal')		
		@include('products.cart_modal')

		@if ($data['result_count']['total'] > 0)
			<div ng-controller="ProductSearchResultsController" ng-init='init({{ $data_json }})' wait wait-watch="addingToCart">
				<p class="well well-sm">
					@lang('wells.products.search.results', ['from' => $data['result_count']['from'], 'to' => $data['result_count']['to'], 'total' => $data['result_count']['total']])
				</p>		

				<div id="product-results">
					@foreach ($data['results'] as $index => $item)			
						<div class="row row-no-sidemargin">
							<div class="col-md-2 col-sm-3 text-center">
								@if (count($item->images))
									<a href="#" ng-click="openModal($event, <?php echo $index; ?>)" class="img">
            							<span class="product-hover"><i class="fa fa-4x fa-search-plus"></i></span>
										<img class="img-responsive" src="/images/products/sm/{{ $item->images[0]->filename }}" alt="{{ $item->descripcion_es }}" />
									</a>									
								@else
									<span class="rapinese-icon rapinese-icon-no-photo" style="font-size: 70px;"></span>
								@endif
							</div>
							<div class="col-md-6 col-sm-4">										
								<div class="product-name mb20">{{ $item->name_es }}</div>
								<div><strong>@lang('labels.code')</strong> {{ $item->code }}</div>
								@if (!empty($item->material->name_es))
									<div><strong>@lang('labels.material')</strong> {{ $item->material->name_es }}</div>
								@endif									
							</div>
							<div class="col-md-1 col-sm-1 product-price">			
								{{ $item->formatted_price_ars }}
							</div>
							<div class="col-md-3 col-sm-4 text-center">
								<p>
									<a class="btn btn-success btn-block hidden-print hidden-xs hidden-sm" 
										ng-click="addToCart($event, {{ $index }})" 
										href="{{ route('cart-add-ajax', $item->code) }}" 
										data-cart-path="{{ route('cart-ajax') }}">
										<span class="glyphicon glyphicon-shopping-cart"></span> @lang('buttons.add_to_cart')
									</a>
									<a class="btn btn-success btn-block hidden-md hidden-lg hidden-print" href="{{ route('cart-add', $item->code) }}">
										<span class="glyphicon glyphicon-shopping-cart"></span> @lang('buttons.add_to_cart')
									</a>									
								</p>
								<p>
									<button class="btn btn-default btn-block hidden-print" ng-click="openQueryModal($event, <?php echo $index; ?>)">
										<span class="glyphicon glyphicon-question-sign"></span> @lang('buttons.ask')
									</button>
								</p>
							</div>
						</div>
					@endforeach		
				</div>
				
				<div class="hidden-print text-center">
					{!! $data['results']->render() !!}
				</div>

				
							
			</div>

		@else

			<p class="alert alert-danger">
				@lang('alerts.search_no_results')
			</p>

		@endif
			
	</div>
@stop

@section('scripts')
	@parent
	{!! HTML::script('js/products.js') !!}	
@stop
