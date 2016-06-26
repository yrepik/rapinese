<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

class CheckoutController extends Controller
{
    
    public function getIndex(Request $request, $result)
    {
        switch ($result) {
            case 'success':
                $text = Lang::get('La operación fue exitosa.');
                $cssClass = 'success';
                break;
            case 'failure':
                $text = Lang::get('Se ha producido un error con el pago.');
                $cssClass = 'danger';
                break;
            case 'pending':
                $text = Lang::get('El pago está pendiente.');
                $cssClass = 'warning';
                break;
        }
        $request->session()->flash('result-displayed', true);
        return view('checkout/index', [
            'text' => $text,
            'cssClass' => $cssClass
        ]);
    }

}