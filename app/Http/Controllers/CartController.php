<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Cart;
use MP;
use App\Product;

class CartController extends Controller
{

    public function index()
    {
        $content = Cart::content();
        $total = Cart::total();

        return view('cart/index', [
            'content' => $content,
            'count' => Cart::count(),
            'total' => $total
        ]);
    }

    public function submitOrder(Request $request)
    {
        $content = Cart::content();

        $total = $content->sum('price');

        $itemNames = [];
        foreach ($content as $item) {
            $name = $item->name;
            if ($item->qty > 1) {
                $name .= ' (' . $item->qty .')';
            }
            $itemNames[] = $name;
        }

        //$item = $content->first();

        $shippingMethod = ($request->has('shippingMethod'))
            ? (int) $request->input('shippingMethod')
            : null;

        $preferenceData = [
            'back_urls' => [
                'success' => route('checkout', 'success'),
                'failure' => route('checkout', 'failure'),
                'pending' => route('checkout', 'pending')
            ],
            'shipments' => [
                'mode' => $request->input('shipment') == 'oca' ? 'me2' : null,
                'dimensions' => '30x30x30,500',
                'default_shipping_method' => $shippingMethod
            ],
            'items' => [
                [
                    'title' => /*$item->name,*/ implode(' + ', $itemNames),
                    'quantity' => 1, //$item->qty,
                    'category_id' => 'automotive',
                    'currency_id' => config('app.currency'),
                    'unit_price' => /*$item->price + $tax,*/ $total,
                    'picture_url' => /*array_key_exists('img', $item->options)
                        ? $item->options['img']
                        : null*/null
                ]
            ]
        ];

        $preference = MP::create_preference($preferenceData);
        $request->session()->put('preference_id', $preference['response']['id']);
        return redirect()->to($preference['response']['init_point']);
    }

    public function addItem($code)
    {
        $product = Product::find($code);

        if (empty($product)) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        $options = [];
        //$options['dimensions'] = $product->category()->dimensions;
        if ($product->hasImg()) {
            $options['img'] = asset('images/products/sm/' . $product->images[0]->filename);
        }

        Cart::add([
            'id' => $product->code,
            'name' => $product->name_es,
            'qty' => 1,
            'price' => $product->price_ars,
            'options' => $options
        ]);

        return redirect()->route('cart');
    }

    public function addItemAjax(Request $request, $code)
    {

        $product = Product::find($code);

        if (empty($product)) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        $options = [];
        //$options['dimensions'] = $product->category()->dimensions;
        if ($product->hasImg()) {
            $options['img'] = asset('images/products/sm/' . $product->images[0]->filename);
        }

        Cart::add([
            'id' => $product->code,
            'name' => $product->name_es,
            'qty' => 1,
            'price' => $product->price_ars,
            'options' => $options
        ]);

        return response()->json([
            'content' => Cart::content()
        ]);
    }

    public function getCartAjax()
    {
        return response()->json([
            'content' => Cart::content(),
            'total' => Cart::total()
        ]);
    }

    public function removeItem($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('cart')->with(['item_deleted' => true]);
    }

    public function emptyCart()
    {
        Cart::destroy();
        return redirect()->route('cart')->with(['cart_emptied' => true]);
    }

    public function updateCart($code, $qty)
    {

    }

    public function calculateShipping(Request $request)
    {
        $content = Cart::content();
        $item = $content->first();
        $dimensions = '10x70x30,2000'; //$item->options['dimensions'];

        $itemPrice = 0.00;
        foreach ($content as $item) {
            $itemPrice += $item->price;
        }

        $response = MP::get('/shipping_options', [
            'dimensions' => $dimensions,
            'zip_code' => $request->input('zipCode'),
            'item_price' => $itemPrice
        ]);
        return response()->json($response);
    }

}
