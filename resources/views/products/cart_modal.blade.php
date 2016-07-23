<script type="text/ng-template" id="cart-modal">
    <div class="modal-header">
        <button ng-click="close()" type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3>@lang('headers.cart')</h3>
    </div>
    <div class="modal-body">
        {!! Form::open(['action' => ['CartController@postSubmitOrder'], 'role' => 'form', 'method' => 'post']) !!}
            <p ng-repeat="item in cart.content">
                %%item.name%% (x%%item.qty%%)
            </p>
            <ul class="list-inline text-center">
                <li><a href="{{ route('cart') }}">@lang('buttons.edit_cart')</a></li>
                <li>
                    <button type="submit" class="btn btn-lg btn-success">
                        @lang('buttons.cart.proceed_to_checkout')
                    </button>
                </li>
            </ul>
        {!! Form::close() !!}
    </div>
</script>