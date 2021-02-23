<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeMoney extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected  $table ="exchange_moneys";

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function fromCurrency()
    {
        return $this->belongsTo('App\Currency','from_currency_id','id');
    }
    public function toCurrency()
    {
        return $this->belongsTo('App\Currency','receive_currency_id','id');
    }


}
