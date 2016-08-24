<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Material extends Model
{

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
