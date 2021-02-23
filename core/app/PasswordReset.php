<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $guarded=[];

    protected $table="password_resets";
}
