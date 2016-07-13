<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Brand extends Model
{
	
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function scopeOptionsForSelect($query)
    {
        return $query
            ->orderBy('order')
            ->lists('name', 'alias')
            ->all();
    }

}
