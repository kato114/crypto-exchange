<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawLog extends Model
{
    protected $table = 'withdraw_logs';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function method()
    {
        return $this->belongsTo('App\WithdrawMethod','method_id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency','currency_id','id');
    }

    public function wallet()
    {
        return $this->belongsTo('App\Wallet','wallet_id');
    }

}
