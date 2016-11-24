<script type="text/ng-template" id="cart-modal">
    <div class="modal-header">
        <button ng-click="close()" type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3>@lang('headers.cart')</h3>
    </div>
    <div class="modal-body">
        {!! Form::open(['action' => ['CartController@submitOrder'], 'role' => 'form', 'method' => 'post']) !!}
            <table class="table table-striped">
                <tr>
                    <th>@lang('Descripción')</th>
                    <th class="text-center">@lang('labels.price', ['currency' => config('app.currency')])</th>
                    <th class="text-center">@lang('labels.quantity')</th>
                </tr>
                <tr ng-repeat="item in cart.content">
                    <td>@{{ item.name }}</td>
                    <td class="text-right">@{{ item.price | number:2 }}</td>
                    <td class="text-center">@{{ item.qty }}</td>
                </tr>
                <tr>
                    <td class="text-right"><strong>@lang('labels.total', ['currency' => config('app.currency')])</strong></td>
                    <td class="text-right">@{{ cart.total }}</td>
                    <td></td>
                </tr>
            </table>

            <ul class="list-inline text-center mt20">
                <li><button class="btn btn-default" type="button" ng-click="close()">@lang('buttons.continue_shopping')</button></li>
                <li><a href="{{ route('cart') }}" class="btn btn-primary">@lang('buttons.edit_cart')</a></li>
                <!--<li>
                    <button type="submit" class="btn btn-success">
                        @lang('buttons.proceed_to_checkout')
                    </button>
                </li>-->
            </ul>
        {!! Form::close() !!}
    </div>
</script>
