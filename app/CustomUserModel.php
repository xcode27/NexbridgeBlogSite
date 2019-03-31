<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomUserModel extends Model
{
    //
    protected $table = "custom_user_models";
    public $timestamps = false;
    protected $guard = ['updated_at'];
    protected $fillable = [
    						'fullname',
    						'birthdate',
    						'username',
    						'password',
    						'photo',
    						'date_last_login',
    						'created_at',
    						'updated_at',
    						'visitor',
    						'email'];
}
