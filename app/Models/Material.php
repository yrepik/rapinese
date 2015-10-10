<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Material extends Eloquent {

    //use SoftDeletingTrait;

    protected $table = 'material'; 	
	
    public function products() {
        return $this->hasMany('Product');
    }  

}
