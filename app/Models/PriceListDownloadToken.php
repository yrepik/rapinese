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

    public function isValid($token)
    {
        return $this->byValueAndDaysOld($token, 2)->count() > 0;
    }

    public function scopeByValueAndDaysOld($query, $token, $days)
    {
        return $query
            ->where('value', $token)
            ->whereDate('created_at', '>=', Carbon::today()->subDays($days)->toDateString());
    } 

}
