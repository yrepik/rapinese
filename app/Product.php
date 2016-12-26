<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $primaryKey = 'code';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
    */
    public $incrementing = false;

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_code', 'code');
    }

    public function scopeForBrandAndCategory($query, $brandId, $categoryId)
    {
        return $query
			->where('brand_id', $brandId)
			->where('product_category_id', $categoryId);
            //->has('images');
    }

    public function scopeByName($query, $name)
    {
        $pieces = explode(' ', $name);
        $like = '%' . implode('%', $pieces) . '%';
        return $query
            ->where('name_es', 'LIKE', $like);
    }

    public function scopeSearch($query, $brandId, $categoryId, $name = null)
    {
        $query
            ->with('material')
            ->with('images')
            ->forBrandAndCategory($brandId, $categoryId);

        if ($name != null) {
            $query->byName($name);
        }

        $query->orderBy('name_es', 'asc');
        return $query;
    }

    public function getFormattedPriceArsAttribute()
    {
        return config('app.currency') . ' ' . number_format($this->price_ars, 2, ',', '.');
    }

    /*public function getNameEsAttribute($value)
    {
        return ucwords(strtolower($value));
    }*/

    public function hasImg()
    {
        return count($this->images) > 0;
    }

}
