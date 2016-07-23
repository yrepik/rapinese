<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>RAPINESE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="." />
        <link media="all" type="text/css" rel="stylesheet" href="/css/lib.css" />  
    </head>
    <body style="padding-top: 30px;">
    
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="navbar-brand">
                            <a href="{{ route('welcome') }}">Rapinese Admin</a>
                        </div>                            
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="navbar">
                        <ul id="nav-main" class="nav navbar-nav">
                            <li><a href="">NAV 1</a></li>
                            <li><a href="">NAV 2</a></li>
                        </ul> 
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/admin/auth/logout">Salir</a></li>
                        </ul>                                              
                    </div>                    
                </div>
            </nav>

            <div id="content">
                @yield('content')
            </div>            
        </div>

    </body>
</html>
