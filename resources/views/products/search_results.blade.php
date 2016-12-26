@extends('layouts.master')

@section('title')
	{{ $category->name_es }} {{ $brand->name }}
@stop

@section('meta-description')

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
			<div ng-controller="ProductSearchResultsController" ng-init='init({{ $data_json }})' ng-cloak wait wait-watch="addingToCart">
				<p class="well well-sm">
					@lang('wells.products.search.results', ['from' => $data['result_count']['from'], 'to' => $data['result_count']['to'], 'total' => $data['result_count']['total']])
				</p>

				<div id="product-results">
					@foreach ($data['results'] as $index => $item)
						<div class="row row-no-sidemargin">
							<div class="col-md-2 col-sm-3 col-xs-4 col-xxs-12 text-center mb20-sm">
								@if (count($item->images))
									<a href="#" ng-click="openModal($event, <?php echo $index; ?>)" class="img">
            							<span class="product-hover"><i class="fa fa-4x fa-search-plus"></i></span>
										<img class="img-responsive" src="/images/products/sm/{{ $item->images[0]->filename }}" alt="{{ $item->descripcion_es }}" />
									</a>
								@else
									<span class="fa-stack fa-3x">
										<span class="fa fa-camera fa-stack-1x"></span>
										<span class="fa fa-ban fa-stack-2x text-danger"></span>
									</span>
								@endif
							</div>
							<div class="col-md-5 col-sm-4 col-xs-8 col-xxs-12 mb20-sm">
								<div class="product-name mb20">
									<a><big>{{ $item->name_es }}</big></a>
								</div>
								<div style="color: #555;"><strong>@lang('labels.code')</strong> {{ $item->code }}</div>
								@if (!empty($item->material->name_es))
									<div style="color: #555;"><strong>@lang('labels.material')</strong> {{ $item->material->name_es }}</div>
								@endif
							</div>
							<div class="clearfix visible-xs"></div>
							<div class="col-md-2 col-sm-2 col-xs-4 col-xxs-12 text-center mb20-sm product-price">
								<big><strong>{{ $item->formatted_price_ars }}</strong></big>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-8 col-xxs-12 text-center">
								<p>
									<button type="button"
										class="btn btn-success btn-block hidden-print visible-md visible-lg"
										ng-click="addToCart($event, {{ $index }}, '{{ route('cart-add-ajax', $item->code) }}', '{{ route('cart-ajax') }}')"
										ng-disabled="addingToCartIndex == {{ $index }}">
										<span class="glyphicon glyphicon-shopping-cart"></span>
										<span ng-show="addingToCartIndex != {{ $index }}">@lang('buttons.add_to_cart')</span>
										<span ng-show="addingToCartIndex == {{ $index }}">@lang('Agregando...')</span>
									</button>
									<a class="btn btn-success btn-block visible-xs visible-sm hidden-print" href="{{ route('cart-add', $item->code) }}">
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

@push('scripts')
	{!! HTML::script('js/products.js') !!}
@endpush
