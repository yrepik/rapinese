<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use Cart;

class CheckoutController extends Controller
{
    
    public function getIndex(Request $request, $result)
    {
        $cond = $request->session()->has('preference_id')
            && $request->has('preference_id')
            && $request->session()->get('preference_id') == $request->input('preference_id');

        if (!$cond) {
            abort(404);
        }
        
        switch ($result) {
            case 'success':
                $text = Lang::get('La operación fue exitosa.');
                $cssClass = 'success';
                Cart::destroy();
                break;
            case 'failure':
                $text = Lang::get('Se ha producido un error con el pago.');
                $cssClass = 'danger';
                break;
            case 'pending':
                $text = Lang::get('El pago está pendiente.');
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