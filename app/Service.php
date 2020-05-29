<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'periodindays',
        'price',
        'likes',
        'posts',
        'views',
        'bonus_comments',
        'bonus_posts',
        'igtv_unlim',
    ];

}
