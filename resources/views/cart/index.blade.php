@extends('layouts.master')

@section('title')
    @lang('Carrito de compras')
@stop

@section('content')
    <div id="cart" ng-app="cart" ng-controller="CartController" ng-init="init({{ $content }}, {{ $count }}, '{{ $subtotal }}', '{{ $tax }}', '{{ $total }}')" ng-cloak>
        <h1>@lang('headers.cart')</h1>

        @if (!count($content))
            <div class="alert alert-warning">
                @lang('alerts.no_items_in_cart')
            </div>    
        @else

            @if (session('checkout_failure_msg'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    @lang('alerts.checkout.failure')
                </div>
            @endif

            {!! Form::open(['action' => ['CartController@postSubmitOrder'], 'role' => 'form', 'method' => 'post', 'class' => 'hidden-print mb20']) !!}
                @foreach ($content as $item)
                    <div class="row row-no-sidemargin item">
                        <div class="col-md-2 col-sm-3 col-xs-5 text-center">
                            @if (count($item->options->img))
                                <img src="{{ $item->options->img }}" class="img-responsive" />                        
                            @else
                                <span class="fa-stack fa-3x">
                                    <span class="fa fa-camera fa-stack-1x"></span>
                                    <span class="fa fa-ban fa-stack-2x text-danger"></span>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-7">               
                            <div>{{ $item->name }}</div>
                            <div><strong>@lang('labels.code')</strong> {{ $item->id }}</div>
                        </div>
                        <div class="clearfix visible-xs"></div>
                        <div class="col-md-1 col-sm-2 col-xs-4 text-right">           
                            {{ config('app.currency') }} {{ number_format($item->price, 2, ',', '.') }}
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-4 text-center">
                            x{{ $item->qty }}
                        </div>
                        <div class="col-md-1 col-sm-2 col-xs-4 text-center">
                            <a href="{{ route('cart-remove', $item->rowId) }}" 
                                class="remove-item" 
                                prompt 
                                prompt-title="@lang('headers.modal.confirmation')" 
                                prompt-ok="@lang('buttons.confirm')" 
                                prompt-cancel="@lang('buttons.cancel')" 
                                prompt-text="@lang('Confirma que desea eliminar el ítem ' . $item->name  . '?')" 
                                prompt-confirm-url="{{ route('cart-remove', $item->rowId) }}">
                                <span class="glyphicon glyphicon-remove" uib-tooltip="@lang('tooltips.cart.remove_item')" tooltip-placement="top"></span>
                            </a>
                        </div>
                    </div>  
                @endforeach
                <div id="totals" class="row row-no-sidemargin">
                    <div class="col-lg-offset-6 col-lg-3 col-md-offset-5 col-md-4 col-sm-offset-4 col-sm-5 col-xs-offset-7 text-right">         
                        <dl class="dl-horizontal">
                            <dt>@lang('labels.subtotal', ['currency' => config('app.currency')])</dt>
                            <dd>%%subtotal%%</dd>
                            <dt>@lang('labels.tax', ['currency' => config('app.currency')])</dt>
                            <dd>%%tax%%</dd>
                            <dt>@lang('labels.total', ['currency' => config('app.currency')])</dt>
                            <dd>%%total%%</dd>
                        </dl>
                    </div>
                </div> 

                <div class="row mb20">
                    <div class="col-md-4 col-sm-6 mb20-sm">
                        <div class="radio">
                            <label ng-class="{'text-muted': shippingDisabled}">
                                <input type="radio" name="shipment" value="oca" ng-model="shipment" ng-disabled="shippingDisabled">
                                Enviar vía OCA (hasta 3 unidades)
                            </label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="shipment" value="pickup" ng-model="shipment">Retiro personalmente (zona Villa Ballester)</label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb20-sm" ng-show="shipment == 'oca'">
                        <h4>Costo de envío</h4>
                        <div class="input-group">
                            <input type="text" 
                                class="form-control text-right" 
                                placeholder="Código postal" 
                                maxlength="8" 
                                ng-model="zipCode"
                                ng-keypress="sarasa($event)" />
                            <span class="input-group-btn">
                                <button id="calc-shipping-cost" 
                                    class="btn btn-default" 
                                    type="button" 
                                    data-request-path="{{ route('cart-calculate-shipping') }}" 
                                    ng-click="getShippingOptions()" 
                                    ng-disabled="calculateShippingCostDisabled()">
                                    <span ng-show="!calculatingShippingCost">Calcular</span>
                                    <span ng-show="calculatingShippingCost">Calculando...</span>
                                </button>
                            </span>
                        </div> 
                        <div class="radio" ng-repeat="shippingOption in shippingOptions">
                            <label>
                                <input type="radio" name="shippingMethod" value="%%shippingOption.shipping_method_id%%" ng-model="shipingMethod">
                                <span class="fa fa-truck"></span>  %%shippingOption.name%%: %%shippingOption.currency_id%% %%shippingOption.cost%%
                            </label>
                        </div>
                        <div class="alert alert-danger mt20" ng-show="shippingCostCalcFailed">
                            Se ha producido un error.
                        </div>
                    </div>
                    <div class="col-md-4" ng-show="shipment == 'oca'">
                    </div>
                </div>

                <div class="row">
                    <div id="mp" class="col-md-4 mb20-sm text-center-sm">
                        <small class="mr20">@lang('texts.processed_by')</small> 
                        <img src="images/logo-mercadopago.png" style="width: 96px;" />
                    </div>
                    <div id="cta" class="col-md-8 text-right text-center-sm">
                        <ul class="list-inline">
                            <li>
                                <a href="{{ route('cart-empty') }}" 
                                    promt  
                                    prompt-title="@lang('headers.modal.confirmation')" 
                                    prompt-ok="@lang('buttons.confirm')" 
                                    prompt-cancel="@lang('buttons.cancel')" 
                                    prompt-text="Confirma que desea eliminar todos los ítems del carrito?" 
                                    prompt-confirm-url="{{ route('cart-empty') }}"
                                    class="btn btn-lg btn-danger">
                                    @lang('buttons.empty_cart')
                                </a>
                            </li>
                            <li><a href="{{ route('products') }}" class="btn btn-lg btn-default">@lang('buttons.continue_shopping')</a></li>
                            <li><button type="submit" class="btn btn-lg btn-success">@lang('buttons.proceed_to_checkout')</button></li>
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
