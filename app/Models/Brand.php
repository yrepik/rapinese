<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Brand extends Model
{

    protected $table = 'brand'; 	
	
    public function products()
    {
        return $this->hasMany('Product');
    }  

}
