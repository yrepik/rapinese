<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProductCategory extends Eloquent {

    //use SoftDeletingTrait;

    protected $table = 'product_category'; 	
	
    public function products() {
        return $this->hasMany('Product');
    }  

}
