<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    protected $table = 'withdraw_methods';

    protected $fillable = ['name','image','fix','percent','duration','status','withdraw_min','withdraw_max'];


}
