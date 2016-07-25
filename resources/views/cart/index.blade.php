@extends('layouts.master')

@section('title')
    @lang('Carrito de compras')
@stop

@section('content')
    <div id="cart" ng-app="cart" ng-controller="CartController">
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
                        <div class="col-md-2 col-sm-3 text-center">
                            @if (count($item->options->img))
                                <img src="{{ $item->options->img }}" class="img-responsive" />                                   
                            @else
                                <span class="rapinese-icon rapinese-icon-no-photo" style="font-size: 70px;"></span>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-4">                                     
                            <div class="product-name">{{ $item->name }}</div>
                            <div><strong>@lang('labels.code')</strong> {{ $item->id }}</div>
                        </div>
                        <div class="col-md-1 col-sm-1 text-right product-price">           
                            {{ config('app.currency') }} {{ number_format($item->price, 2, ',', '.') }}
                        </div>
                        <div class="col-md-2 col-sm-2 text-center">
                            x{{ $item->qty }}
                        </div>
                        <div class="col-md-1 col-sm-2 text-center">
                            <a href="{{ route('cart-remove', $item->rowId) }}" 
                                class="remove-item" 
                                ng-click="confirm($event)" 
                                data-title="@lang('headers.modal.confirmation')" 
                                data-ok="@lang('buttons.confirm')" 
                                data-cancel="@lang('buttons.cancel')" 
                                data-text="@lang('Confirma que desea eliminar el ítem ' . $item->name  . '?')">
                                <span class="glyphicon glyphicon-remove" uib-tooltip="@lang('tooltips.cart.remove_item')" tooltip-placement="top"></span>
                            </a>
                        </div>
                    </div>  
                @endforeach
                <div class="row row-no-sidemargin">
                    <div class="col-md-offset-6 col-md-3 text-right">         
                        <dl class="dl-horizontal">
                            <dt>@lang('labels.subtotal', ['currency' => config('app.currency')])</dt>
                            <dd>{{ $subtotal }}</dd>
                            <dt>@lang('labels.tax', ['currency' => config('app.currency')])</dt>
                            <dd>{{ $tax }}</dd>
                            <dt>@lang('labels.total', ['currency' => config('app.currency')])</dt>
                            <dd>{{ $total }}</dd>
                        </dl>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-4">
                        <div class="radio">
                            <label><input type="radio" name="shipment" value="oca" ng-model="shipment">Enviar vía OCA</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="shipment" value="pickup" ng-model="shipment">Retiro personalmente (zona Villa Ballester)</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="alert alert-warning" ng-show="shipment == 'oca'">
                            @lang('alerts.shipping_cost_not_included')
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <small class="mr20">@lang('texts.processed_by')</small> 
                        <img src="images/logo-mercadopago.png" style="width: 96px;" />
                    </div>
                    <div class="col-md-8">
                        <ul class="list-inline text-right">
                            <li>
                                <a href="{{ route('cart-empty') }}" 
                                    ng-click="confirm($event)" 
                                    data-title="@lang('headers.modal.confirmation')" 
                                    data-ok="@lang('buttons.confirm')" 
                                    data-cancel="@lang('buttons.cancel')" 
                                    data-text="Confirma que desea eliminar todos los ítems del carrito?" 
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
