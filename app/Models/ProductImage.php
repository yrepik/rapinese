<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProductImage extends Model
{

    protected $table = 'product_image'; 	
	
    public function product()
    {
        return $this->belongsTo('Product', 'product_code');
    }

}
