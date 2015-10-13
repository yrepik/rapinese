@extends('layouts.master')

@section('content')
	<div ng-app="home">
		<div class="row" ng-controller="HomeCarouselController" ng-cloak>
			<div>
				<carousel interval="myInterval">
					<slide ng-repeat="slide in slides" active="slide.active">
						<img ng-src="%%slide.image%%">
					</slide>
				</carousel>
			</div>
		</div>

		<div id="icons" class="row mt20">
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="text-center"><i class="fa fa-4x fa-graduation-cap"></i></div>
				<h3 class="text-center">@lang('Trayectoria')</h3>
				<p>@lang('Desde 1965 nos especializamos en la fabricación y distribución de autopartes de carrocerías.')</p>
				<p>@lang('Actualmente producimos más de 1000 piezas, lo que nos convierte en la mayor y más completa productora dentro del rubro.')</p>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="text-center"><i class="fa fa-4x fa-check"></i></div>
				<h3 class="text-center">@lang('Calidad')</h3>
				<p>@lang('Estamos capacitados para proyectar, desarrollar y ejecutar el herramental requerido para producir cualquier pieza dentro de la especialidad, según el requerimiento del cliente, bajo estrictas normas y especificaciones de calidad.')</p>
			</div>
			<div class="clearfix visible-xs-block visible-sm-block hidden-md hidden-lg"></div>			
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="text-center"><i class="fa fa-4x fa-refresh"></i></div>
				<h3 class="text-center">@lang('Stock permanente')</h3>
				<p>@lang('Contamos con un alto nivel de stock en forma permanente, lo que nos permite una ágil y eficiente atención al cliente.')</p>
				<p>@lang('Asimismo, disponemos de un sistema de distribución y ventas a mayoristas, distribuidores y comerciantes, que posibilita a nuestros productos llegar a todo el país.')</p>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="text-center"><i class="fa fa-4x fa-globe"></i></div>
				<h3 class="text-center">@lang('Exportaciones')</h3>
				<p>@lang('Mercado local, países limítrofes, África, Países Árabes, Europa, China.')</p>
			</ul>
			</div>									
		</div>
	</div>
@stop

@section('scripts')
	@parent
	{!! HTML::script('js/home.js') !!}
@stop