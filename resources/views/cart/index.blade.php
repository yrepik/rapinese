@extends('layouts.master')

@section('content')
    <div id="cart" ng-app="cart" ng-controller="CartController">
        <h1>Carrito de compras</h1>

        @if (!count($content))
            <div class="alert alert-warning">
                No hay ítems en su carrito de compras. <a href="{{ route('products') }}">Agregar</a>.
            </div>    
        @else
            {!! Form::open(['action' => ['CartController@postSubmitOrder'], 'role' => 'form', 'method' => 'post', 'class' => 'hidden-print mb20']) !!}
                @foreach ($content as $item)
                    <div class="row row-no-sidemargin item">
                        <div class="col-md-2 col-sm-3 text-center">
                            @if (count($item->options->img))
                                <img src="{{ $item->options->img }}" class="img-responsive" />                                   
                            @else
                                <span class="rapinese-icon rapinese-icon-no-photo"  style="font-size: 70px;"></span>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-4">         
                            <div class="product-code"><strong>{{ $item->id }}</strong></div>
                            <div class="product-name">{{ $item->name }}</div>
                            <!--<div><span>{{ @$item->material->name_es }}</span></div>-->
                        </div>
                        <div class="col-md-1 col-sm-1 text-right product-price">           
                            {{ config('app.currency') }} {{ number_format($item->price, 2, ',', '.') }}
                        </div>
                        <div class="col-md-2 col-sm-2 text-center">
                            x{{ $item->qty }}
                        </div>
                        <div class="col-md-1 col-sm-2 text-center">
                            <a href="{{ route('cart-remove', $item->rowId) }}" ng-click="confirm($event)" data-text="@lang('Confirma que desea eliminar el ítem ' . $item->name  . '?')">
                                <span class="glyphicon glyphicon-remove" uib-tooltip="@lang('Remover ítem del carrito')" tooltip-placement="top"></span>
                            </a>
                        </div>
                    </div>  
                @endforeach
                <div class="row row-no-sidemargin">
                    <div class="col-md-offset-5 col-md-4 text-right">         
                        <dl class="dl-horizontal">
                            <dt>Subtotal:</dt>
                            <dd>{{ config('app.currency') }} {{ $subtotal }}</dd>
                            <dt>IVA:</dt>
                            <dd>{{ config('app.currency') }} {{ $tax }}</dd>
                            <dt>Total:</dt>
                            <dd>{{ config('app.currency') }} {{ $total }}</dd>
                        </dl>
                    </div>
                </div> 

                <!--<div class="row row-no-sidemargin">
                    <div class="col-md-8 col-sm-7 text-right">         
                        <strong>Subtotal:</strong>
                    </div>
                    <div class="col-md-4 col-sm-5 product-price">           
                        {{ config('app.currency') }} {{ $subtotal }}
                    </div>
                </div> 

                <div class="row row-no-sidemargin">
                    <div class="col-md-8 col-sm-7 text-right">         
                        <strong>IVA:</strong>
                    </div>
                    <div class="col-md-4 col-sm-5 product-price">           
                        {{ config('app.currency') }} {{ $tax }}
                    </div>
                </div>      
                <div class="row row-no-sidemargin mb20">
                    <div class="col-md-8 col-sm-7 text-right">         
                        <strong>Total:</strong>
                    </div>
                    <div class="col-md-4 col-sm-5 product-price">           
                        {{ config('app.currency') }} {{ $total }}
                    </div>
                </div>-->
                <div class="alert alert-warning mb20">
                    <strong>Importante:</strong> El costo del envío no está incluído, se le informará en el siguiente paso.
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img src="images/mercadopago-vertical-logo-95x88.png" class="img-responsive" />
                    </div>
                    <div class="col-md-8">
                        <ul class="list-inline text-right">
                            <li>
                                <a href="{{ route('cart-empty') }}" ng-click="confirm($event)" data-text="Confirma que desea eliminar todos los ítems del carrito?" class="btn btn-lg btn-danger">Vaciar carrito</a>
                            </li>
                            <li><a href="{{ route('products') }}" class="btn btn-lg btn-default">Continuar comprando</a></li>
                            <li><button type="submit" class="btn btn-lg btn-success">Proceder con el pago</button></li>
                        </ul>
                    </div>
                </div>
            {!! Form::close() !!}
        @endif

        @section('scripts')
            @parent
            {!! HTML::script('js/cart.js') !!}
        @stop        
    </div>
@stop
