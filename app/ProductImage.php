<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProductImage extends Model
{
	
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_code');
    }

}
