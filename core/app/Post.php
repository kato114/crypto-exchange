<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $guarded =[];


    public function category()
    {
        return $this->belongsTo('App\Category','cat_id','id');
    }

}
