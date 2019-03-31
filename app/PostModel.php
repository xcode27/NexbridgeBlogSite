<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    //
    protected $table = "post_models";
    public $timestamps = false;
    protected $fillable = ['user_id','Title','Body','date_created','date_modified'];


}
