<?php
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'product';

    protected $primaryKey = 'code'; 

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
    */
    public $incrementing = false;
    
    public function brand()
    {
        return $this->belongsTo('Brand', 'brand_id');
    } 	
	
    public function category()
    {
        return $this->belongsTo('ProductCategory', 'product_category_id');
    } 	
	
    public function material()
    {
        return $this->belongsTo('Material', 'material_id');
    } 	
	
    public function images()
    {
        return $this->hasMany('ProductImage', 'product_code', 'code');
    }
	
    public function scopeForBrandAndCategory($query, $brandId, $categoryId)
    {
        return $query
			->where('brand_id', $brandId)
			->where('product_category_id', $categoryId);
    }

    public function scopeSearch($query, $brandId, $categoryId, $itemsPerPage)
    {
        return $query
            ->with('material')
            ->with('images')
            ->forBrandAndCategory($brandId, $categoryId)
            ->orderBy('name_es', 'asc')
            ->paginate($itemsPerPage);
    }
    
    public function getFormattedPriceArsAttribute() {
        return config('app.currency') . ' ' . number_format($this->price_ars, 2, ',', '.');
    }

    public function hasImg()
    {
        return count($this->images) > 0;
    }

}
