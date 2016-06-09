<?php

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PriceListDownloadToken extends Model
{

    protected $table = 'price_list_download_token';
    public $timestamps = false;
    protected $dates = ['created_at'];
    protected $fillable = ['email'];

    public function getDates()
    {
        return ['created_at'];
    }

    public function coco($token)
    {
        return $this->isValid($token)->count() > 0;
    }

    public function scopeIsValid($query, $token)
    {
        return $query
            ->where('value', $token)
            ->whereDate('created_at', '>=', Carbon::today()->subDays(2)->toDateString());
    } 

}
