<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProductCategory extends Model
{

    protected $table = 'product_category'; 	
	
    public function products()
    {
        return $this->hasMany('Product');
    }  

}
