<!doctype html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RAPINESE @yield('title')</title>        
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
				<div class="col-xs-12 col-sm-4 col-md-4">
					<img src="/images/logo2.png" class="img-responsive" />
				</div>	
				<div class="col-sm-8 col-md-8 hidden-xs" style="padding-top: 20px;">
                    <ul class="list-inline text-center">
                        <li><span class="glyphicon glyphicon-copyright-mark"></span> {{ config('app.company_name') }}</li>
                        <li><span class="glyphicon glyphicon-envelope"></span> {{ config('app.contact_email') }}</li>
                        <li><span class="glyphicon glyphicon-earphone"></span> {{ config('app.contact_phones') }}</li>
                    </ul>
				</div>
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
						<li><a href="{{ route('home') }}">@lang('nav.company')</a></li>
						<li><a href="{{ route('products') }}">@lang('nav.products')</a></li>
						<!--<li><a href="{{ route('price-list') }}">@lang('nav.pricelist')</a></li>-->
                        <!--<li><a href="{{ route('cart') }}">@lang('nav.cart')</a></li>-->
						<li><a href="{{ route('clients') }}">@lang('nav.clients')</a></li>
					</ul>	
					<!--<ul class="nav navbar-nav navbar-right">
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
					</ul>-->
				</div>
			</nav>			
			
            <div id="main" role="main">
                @yield('content') 
            </div>
			
            <footer class="hidden-print text-center">                
                <ul class="list-inline">
                    <li><small><span class="glyphicon glyphicon glyphicon-copyright-mark"></span> {{ config('app.company_name') }} - 1965-{{ date('Y') }}</small></li>
                    <li><small><span class="glyphicon glyphicon-envelope ml20"></span> {{ config('app.contact_email') }}</small></li>
                    <li><small><span class="glyphicon glyphicon-earphone ml20"></span> {{ config('app.contact_phones') }}</small></li>
                </ul>
            </footer> 
			
        </div>

        @section('scripts') 
        	{!! HTML::script('js/base.js') !!}       	
        @stop
        @yield('scripts')        
    </body>
</html>