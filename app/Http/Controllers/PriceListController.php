<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Mail;
use Lang;

use PriceListDownloadToken;

class PriceListController extends Controller
{
    
    public function getIndex()
    {
        return view('price_list/index');
    }

    public function postIndex(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $token = new PriceListDownloadToken();
            $token->value = str_random(30);
            $token->fill($request->all());
            if ($token->save()) {

                $sendResult = Mail::send(
                    'emails.price_list_download_token', 
                    [
                        'token' => $token->value,
                        'first_name' => $request->input('first_name'),
                        'last_name' => $request->input('last_name')
                    ], 
                    function($message) use ($request) {
                        $message
                            ->from('german.medaglia@gmail.com', 'Rapinese SRL')
                            ->to('german.medaglia@gmail.com'/*$request->input('email')*/)
                            ->bcc('german.medaglia@gmail.com')
                            /*->bcc('rapinese@rapinese.com.ar')*/
                            ->subject('Lista de precios');
                    }
                );  
                $result = $sendResult != false;
                $msg = ($result) 
                    ? trans('alerts.products.ask.success') 
                    : trans('alerts.products.ask.error');

                return redirect()
                    ->route('price-list-token-sent')
                    ->with(['email' => $request->input('email'), 'token_sent' => true]);
            } else {

            }
        } else {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }
    }

    public function getTokenSent(Request $request)
    {
        if (!$request->session()->get('token_sent')) {
            return redirect()->route('price-list');
        }        
        return view('price_list/token_sent', ['email' => $request->session()->get('email')]);
    }

    public function getDownload($tokenVal)
    {
        $token = new PriceListDownloadToken();
        $valid = $token->isValid($tokenVal);
        if (!$valid) {
            abort(404);
        }
        return response()->download(base_path() . '/files/lista-de-precios.xls');
    }

}
