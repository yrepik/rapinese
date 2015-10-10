<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProductImage extends Eloquent {

    //use SoftDeletingTrait;

    protected $table = 'product_image'; 	
	
    public function product() {
        return $this->belongsTo('Product', 'product_code');
    }

}
