<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Material extends Model
{

    protected $table = 'material'; 	
	
    public function products()
    {
        return $this->hasMany('Product');
    }  

}
