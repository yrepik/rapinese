<?php namespace App\Http\Controllers;

use Brand;
use ProductCategory;
use Product;
use Request;
use Validator;
use Mail;

class ProductsController extends Controller {
	
    public function getIndex() {
        return view('products/index', ['selected_brand' => null, 'selected_category' => null]);
    }

    public function postSearchRedirect() {
        return redirect('products/search/' . Request::input('brand_id') . '/' . Request::input('category_id'));
    }

    public function getSearchResults($brandAlias, $categoryAlias, $page = 1) {    
    
        $brandId = Brand::where('alias', $brandAlias)->first()->id;
        $categoryId = ProductCategory::where('alias_es', $categoryAlias)->first()->id;

        $itemsPerPage = 20;
        
        $items = Product::search($brandId, $categoryId, $itemsPerPage);
            
        $total = $items->total();
        $from = ($total > 0)
            ? ($items->currentPage() - 1) * $itemsPerPage + 1
            : 0;
        $to = $from + $itemsPerPage - 1;
        if ($to > $total) {
            $to = $total;
        }

        $data = array(
            'result_count' => array(                
                'total' => $total,
                'from' => $from,
                'to' => $to
            ),
            'results' => $items
        );
        return view('products/search_results', [
            'data' => $data, 
            'data_json' => $items->toJson(),
            'selected_brand' => $brandAlias, 
            'selected_category' => $categoryAlias
        ]);   
    }

    public function postSendQuery() {
        $result = null;
        $msg = null;
        $errors = [];

        $validator = Validator::make(Request::all(), [
            'name' => 'required|max:100',
            'email' => 'required|email',
            'tel' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $result = false;
        }        
        Mail::send(
            'emails.product_query', 
            [
                'name' => Request::input('name'), 
                'email' => Request::input('email'),
                'product_code' => Request::input('productCode'),
                'product_description' => Request::input('productDescription')
            ], 
            function($message) {
                $message->to('german.medaglia@gmail.com', 'John Smith')->subject('Consulta desde la web');
            }
        );
        $result = false;
        $msg = 'Salio todo mal!';
        return response()->json(['result' => $result, 'msg' => $msg, 'errors' => $errors]);
    }

}