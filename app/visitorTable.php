<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class visitorTable extends Model
{
    //
    protected $table = "author_visitor_tables";
    public $timestamps = false;
    protected $fillable = ['user_id','profile_visited','date_visited'];
}
