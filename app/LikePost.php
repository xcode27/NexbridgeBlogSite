<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    //
    
    protected $table = "like_posts";
    public $timestamps = false;
    protected $fillable = ['user_id','post_id'];
}
