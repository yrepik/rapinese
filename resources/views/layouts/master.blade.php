<!doctype html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rapinese</title>        
        @section('styles')
            {!! HTML::style('css/lib.css') !!}
            {!! HTML::style('css/styles.css') !!}
        @stop
		<link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Oswald:300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        @yield('styles')	
    </head>
    <body>       

        <div id="page" class="container">
			<header class="row">
				<div class="col-md-4">
					<img src="/images/logo2.png" class="img-responsive" />
				</div>	
				<address class="col-sm-6 col-sm-offset-2 col-md-5 col-md-offset-3 hidden-xs text-right">
					<strong>Rapinese SRL</strong><br />
					<span class="glyphicon glyphicon-envelope"></span> <a href="mailto:#">rapinese@rapinese.com.ar</a><br />			
					<span class="glyphicon glyphicon-earphone"></span> +54 11 4764-5079 / 4768-3166
				</address>
			</header>
			
			<nav class="navbar navbar-inverse" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-collapse collapse" style="height: 1px;">
					<ul class="nav navbar-nav">
						<li><a href="{{ URL::to('/') }}">@lang('Qui&eacute;nes Somos')</a></li>
						<li><a href="{{ URL::to('/products') }}">@lang('Nuestros Productos')</a></li>
						<li><a href="{{ URL::to('/files/lista-de-precios.xls') }}" donwload><i class="glyphicon glyphicon-download-alt"></i> @lang('Lista de precios')</a></li>
						<li><a href="{{ URL::to('/clients') }}">@lang('Quiero ser cliente')</a></li>
					</ul>	
					<ul class="nav navbar-nav navbar-right hidden">
						<li class="dropdown">                             
							<a data-toggle="dropdown" class="dropdown-toggle" href="">								
								@lang('Idioma') <span class="caret"></span>
							</a>                                 
							<ul class="dropdown-menu">
								<li><a href="http://gifwall-admin.mundonick-q.mtvi.com/account/change-lang/es">Español</a></li>
								<li><a href="http://gifwall-admin.mundonick-q.mtvi.com/account/change-lang/en">English</a></li>
								<li><a href="http://gifwall-admin.mundonick-q.mtvi.com/account/change-lang/pt">Portugueis</a></li>
							</ul>                                
						</li>
					</ul>					
				</div>
			</nav>			
			
            <div id="main" role="main">
                @yield('content') 
            </div>
			
			<div id="brands" class="text-center hidden-xs hidden-sm hidden-md">
				<img src="http://www.silvaflex.com/img/brands.jpg" class="img-responsive" />
			</div>
			
            <footer>                
				<small>Rapinese SRL - 1965-{{ date('Y') }}.</small>				
            </footer> 
			
        </div>

        @section('scripts') 
        	{!! HTML::script('js/base.js') !!}       	
        @stop
        @yield('scripts')        
    </body>
</html>