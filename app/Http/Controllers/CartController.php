<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cart;
use MP;
use App\Product;

class CartController extends Controller
{
    
    public function getIndex()
    {
        $content = Cart::content();
        $subtotal = Cart::subtotal(2, ',', '.');
        $tax = Cart::tax(2, ',', '.');
        $total = Cart::total(2, ',', '.');

        return view('cart/index', [
            'content' => $content,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);
    }

    public function postSubmitOrder(Request $request)
    {
        $content = Cart::content();
        $total = Cart::total(2, ',', '.');
        $tax = Cart::tax(2, ',', '.');

        $total2 = 0.00;
        foreach ($content as $item) {
            $total2 += $item->price;
        }
        $total2 += $tax;

        $itemNames = [];
        foreach ($content as $item) {
            $name = $item->name;
            if ($item->qty > 1) {
                $name .= ' (' . $item->qty .')';
            } 
            $itemNames[] = $name;
        }

        //$item = $content->first();        

        $preferenceData = [
            'back_urls' => [
                'success' => route('checkout' , 'success'),
                'failure' => route('checkout', 'failure'),
                'pending' => route('checkout', 'pending')
            ],
            'shipments' => [
                'mode' => $request->input('shipment') == 'oca' ? 'me2' : null,
                'dimensions' => '30x30x30,500',
                //'default_shipping_method' => (int) $request->input('shipping_method')
            ],
            'items' => [
                [
                    'title' => /*$item->name,*/ implode(' + ', $itemNames),
                    'quantity' => 1, //$item->qty,
                    'currency_id' => config('app.currency'),
                    'unit_price' => /*$item->price + $tax,*/ $total2,
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

    public function getAdd($code)
    {        
        $product = Product::find($code);

        if (empty($product)) {
            return abort(404);
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

    public function getAddAjax(Request $request, $code)
    {

        $product = Product::find($code);

        if (empty($product)) {
            return abort(404);
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
            'subtotal' => Cart::subtotal(2, ',', '.'),
            'tax' => Cart::tax(2, ',', '.'),
            'total' => Cart::total(2, ',', '.')
        ]);
    }   

    public function getRemove($rowId)
    {        
        Cart::remove($rowId);
        return redirect()->route('cart')->with(['item_deleted' => true]);
    } 

    public function getEmpty()
    {        
        Cart::destroy();
        return redirect()->route('cart')->with(['cart_emptied' => true]);
    }     

    public function getUpdate($code, $qty)
    {        

    }

    public function getCalculateShipping($zipCode)
    {
        $content = Cart::content();
        $item = $content[0];
        $dimensions = $item->options['dimensions'];
        $itemPrice = $item->price + Cart::tax();

        $response = MP::get('/shipping_options', [
            'dimensions' => $dimensions,
            'zip_code' => $zipCode,
            'item_price' => $itemPrice
        ]);
        return response()->json($response);
    }

}