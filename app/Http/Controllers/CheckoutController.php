<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

class CheckoutController extends Controller
{

    public function index(Request $request, $result)
    {
        $cond = $request->session()->has('preference_id')
            && $request->has('preference_id')
            && $request->session()->get('preference_id') == $request->input('preference_id');

        if (!$cond) {
            //dd($request->session()->get('preference_id'));
            abort(404);
        }

        //$request->session()->get('preference_id')

        switch ($result) {
            case 'success':
                $text = trans('alerts.chekcout.success');
                $cssClass = 'success';
                Cart::destroy();
                break;
            case 'failure':
                if ($request->input('payment_type') == 'null') {
                    return redirect()->route('cart');
                }
                return redirect()->route('cart')->with([
                    'checkout_failure_msg' => trans('alerts.checkout.failure')
                ]);
            case 'pending':
                $text = trans('alerts.checkout.pending');
                $cssClass = 'warning';
                Cart::destroy();
                break;
        }
        return view('checkout/index', [
            'text' => $text,
            'cssClass' => $cssClass
        ]);
    }

}
