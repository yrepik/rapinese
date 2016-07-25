@extends('layouts.master')

@section('content')
	<div ng-app="home">
		<div class="row hidden-xs" ng-controller="HomeCarouselController" ng-cloak>
			<div>
				<uib-carousel interval="myInterval">
					<uib-slide ng-repeat="slide in slides" active="slide.active">
						<img ng-src="%%slide.image%%">
					</uib-slide>
				</uib-carousel>
			</div>
		</div>

		<div id="icons" class="row mt20">
			<div class="col-xs-6 col-sm-6 col-md-3">
				<div class="text-center"><i class="fa fa-4x fa-graduation-cap"></i></div>
				<h3 class="text-center">@lang('headers.home.career')</h3>
				<p>@lang('texts.career_1')</p>
				<p>@lang('texts.career_2')</p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-3">
				<div class="text-center"><i class="fa fa-4x fa-check"></i></div>
				<h3 class="text-center">@lang('headers.home.quality')</h3>
				<p>@lang('texts.quality')</p>
			</div>
			<div class="clearfix visible-xs-block visible-sm-block hidden-md hidden-lg"></div>			
			<div class="col-xs-6 col-sm-6 col-md-3">
				<div class="text-center"><i class="fa fa-4x fa-refresh"></i></div>
				<h3 class="text-center">@lang('headers.home.stock')</h3>
				<p>@lang('texts.stock_1')</p>
				<p>@lang('texts.stock_2')</p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-3">
				<div class="text-center"><i class="fa fa-4x fa-globe"></i></div>
				<h3 class="text-center">@lang('headers.home.exportations')</h3>
				<p>@lang('texts.exportations')</p>
			</ul>
			</div>									
		</div>
	</div>
@stop

@section('scripts')
	@parent
	{!! HTML::script('js/home.js') !!}
@stop