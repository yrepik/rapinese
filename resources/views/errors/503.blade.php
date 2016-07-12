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
            
            <div id="main" role="main" style="padding: 50px;">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <span class="rapinese-icon rapinese-icon-icon" style="font-size: 260px;"></span>
                    </div>
                    <div class="col-md-9 text-center">                        
                        <h4 style="margin-bottom: 40px;">@lang('Estamos realizando tareas de mantenimiento. Pronto estaremos de regreso. Disculpe las molestias.')</h4>
                        <ul class="list-inline">
                            <li><small><span class="glyphicon glyphicon glyphicon-copyright-mark"></span> {{ config('app.company_name') }} - 1965-{{ date('Y') }}</small></li>
                            <li><small><span class="glyphicon glyphicon-envelope ml20"></span> {{ config('app.contact_email') }}</small></li>
                            <li><small><span class="glyphicon glyphicon-earphone ml20"></span> {{ config('app.contact_phones') }}</small></li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
       
    </body>
</html>