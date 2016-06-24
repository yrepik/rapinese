<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Brand;
use ProductCategory;
use Product;
use Validator;
use Mail;
use Lang;

class ProductsController extends Controller
{
	
    public function getIndex()
    {
        return view('products/index', ['selected_brand' => null, 'selected_category' => null]);
    }

    public function getSearchRedirect(Request $request)
    {
        return redirect()->route(
            'product-search-results', 
            ['brand_alias' => $request->input('brand_alias'), 'category_alias' => $request->input('category_alias')]
        );
    }

    public function getSearchResults($brandAlias, $categoryAlias, $page = 1)
    {
        $brand = Brand::where('alias', $brandAlias)->first();
        $category = ProductCategory::where('alias_es', $categoryAlias)->first();

        $itemsPerPage = 20;
        
        $items = Product::search($brand->id, $category->id, $itemsPerPage);
            
        $total = $items->total();
        $from = ($total > 0)
            ? ($items->currentPage() - 1) * $itemsPerPage + 1
            : 0;
        $to = $from + $itemsPerPage - 1;
        if ($to > $total) {
            $to = $total;
        }

        $data = [
            'result_count' => [                
                'total' => $total,
                'from' => $from,
                'to' => $to
            ],
            'results' => $items
        ];
        return view('products/search_results', [
            'data' => $data, 
            'data_json' => $items->toJson(),
            'selected_brand' => $brandAlias, 
            'selected_category' => $categoryAlias,
            'brand' => $brand,
            'category' => $category
        ]);   
    }

    public function postSendQuery(Request $request)
    {
        $result = null;
        $msg = null;
        $errors = [];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100'
        ], [
            'name.required' => trans('El campo Nombre y apellido es requerido.'),
            'email.required' => trans('El campo E-mail es requerido.'),
            'email.email' => trans('El campo E-mail no responde a un formato válido de e-mail.')
        ]);

        if ($validator->passes()) {
            $sendResult = Mail::send(
                'emails.product_query', 
                [
                    'name' => $request->input('name'), 
                    'email' => $request->input('email'),
                    'tel' => $request->input('tel'),
                    'comments' => $request->input('comments'),
                    'product_code' => $request->input('itemCod'),
                    'product_description' => $request->input('itemDescrip')
                ], 
                function($message) {
                    $message
                        ->from($request->input('email'), $request->input('name'))
                        ->to('rapinese@rapinese.com.ar')
                        ->bcc('german.medaglia@gmail.com')
                        ->subject('Consulta desde la web');
                }
            );  
            $result = $sendResult != false;
            $msg = ($result) 
                ? trans('alerts.products.ask.success') 
                : trans('alerts.products.ask.error');
        } else {       
            $errors = $validator->errors()->all();
            $result = false;
        }        
        return response()->json(['result' => $result, 'msg' => $msg, 'errors' => $errors]);
    }

}