@extends('layouts.master')

@section('title')
    @lang('Carrito de compras')
@stop

@section('content')
    <div id="cart" ng-app="cart" ng-controller="CartController">
        <h1>@lang('headers.cart')</h1>

        @if (!count($content))
            <div class="alert alert-warning">
                @lang('alerts.cart.no_items')
            </div>    
        @else
            {!! Form::open(['action' => ['CartController@postSubmitOrder'], 'role' => 'form', 'method' => 'post', 'class' => 'hidden-print mb20']) !!}
                @foreach ($content as $item)
                    <div class="row row-no-sidemargin item">
                        <div class="col-md-2 col-sm-3 text-center">
                            @if (count($item->options->img))
                                <img src="{{ $item->options->img }}" class="img-responsive" />                                   
                            @else
                                <span class="rapinese-icon rapinese-icon-no-photo" style="font-size: 70px;"></span>
                            @endif
                        </div>
                        <div class="col-md-9 col-sm-8">         
                            <div class="product-code"><strong>{{ $item->id }}</strong></div>
                            <div class="product-name">{{ $item->name }}</div>
                            <!--<div><span>{{ @$item->material->name_es }}</span></div>-->
                        </div>
                        <div class="col-md-1 col-sm-1 text-right product-price">           
                            {{ config('app.currency') }} {{ number_format($item->price, 2, ',', '.') }}
                        </div>
                        <!--<div class="col-md-2 col-sm-2 text-center">
                            x{{ $item->qty }}
                        </div>
                        <div class="col-md-1 col-sm-2 text-center">
                            <a href="{{ route('cart-remove', $item->rowId) }}" 
                                ng-click="confirm($event)" 
                                data-title="@lang('headers.modal.confirmation')" 
                                data-ok="@lang('buttons.confirm')" 
                                data-cancel="@lang('buttons.cancel')" 
                                data-text="@lang('Confirma que desea eliminar el ítem ' . $item->name  . '?')">
                                <span class="glyphicon glyphicon-remove" uib-tooltip="@lang('tooltips.cart.remove_item')" tooltip-placement="top"></span>
                            </a>
                        </div>-->
                    </div>  
                @endforeach
                <div class="row row-no-sidemargin">
                    <div class="col-md-offset-8 col-md-4 text-right">         
                        <dl class="dl-horizontal">
                            <dt>@lang('labels.cart.subtotal', ['currency' => config('app.currency')])</dt>
                            <dd>{{ $subtotal }}</dd>
                            <dt>@lang('labels.cart.tax', ['currency' => config('app.currency')])</dt>
                            <dd>{{ $tax }}</dd>
                            <dt>@lang('labels.cart.total', ['currency' => config('app.currency')])</dt>
                            <dd>{{ $total }}</dd>
                        </dl>
                    </div>
                </div> 

                <div class="alert alert-warning mb20">
                    @lang('alerts.cart.shipping_cost_not_included')
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <small class="mr20">@lang('texts.cart.mercado_pago')</small> 
                        <img src="images/logo-mercadopago.png" style="width: 96px;" />
                    </div>
                    <div class="col-md-8">
                        <ul class="list-inline text-right">
                            <!--<li>
                                <a href="{{ route('cart-empty') }}" 
                                    ng-click="confirm($event)" 
                                    data-title="@lang('headers.modal.confirmation')" 
                                    data-ok="@lang('buttons.confirm')" 
                                    data-cancel="@lang('buttons.cancel')" 
                                    data-text="Confirma que desea eliminar todos los ítems del carrito?" 
                                    class="btn btn-lg btn-danger">
                                    @lang('buttons.cart.empty')
                                </a>
                            </li>
                            <li><a href="{{ route('products') }}" class="btn btn-lg btn-default">@lang('buttons.cart.continue_shopping')</a></li>-->
                            <li><button type="submit" class="btn btn-lg btn-success">@lang('buttons.cart.proceed_to_checkout')</button></li>
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
