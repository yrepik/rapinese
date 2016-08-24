<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Brand extends Model
{

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeOptionsForSelect($query)
    {
        return $query
            ->orderBy('order')
            ->pluck('name', 'alias');
    }

}
