<?php

namespace App;

use App\Category;
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

    protected $appends = ['price_formatted'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', ' ');
    }
}
