<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Brand extends Eloquent {

    //use SoftDeletingTrait;

    protected $table = 'brand'; 	
	
    public function products() {
        return $this->hasMany('Product');
    }  

}
