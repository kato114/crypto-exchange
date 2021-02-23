<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  $guarded = [];


    public function posts()
    {
        return $this->hasMany('App\Post','cat_id','id');
    }
}
