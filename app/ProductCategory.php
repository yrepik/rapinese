<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProductCategory extends Model
{

    protected $table = 'product_categories';

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeOptionsForSelect($query)
    {
        return $query
            ->orderBy('name_es')
            ->where('status', 1)
            ->pluck('name_es', 'alias_es');
    }

}
