<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'periodindays',
        'type'
    ];

    protected $appends = [
        'price_formatted',
        'parameters'
    ];

    public const TYPE_LIKES = 'likes';
    public const TYPE_SUBSCRIBERS = 'subscribers';

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return string
     */
    public function getPriceFormattedAttribute(): string
    {
        return number_format($this->price, 0, ',', ' ');
    }

    /**
     * @return HasMany
     */
    public function params(): HasMany
    {
        return $this->hasMany(ServiceParameter::class);
    }

    /**
     * @return array
     */
    public function getParametersAttribute(): array
    {
        $result = [];
        $parameters = $this->params()->get();

        foreach ($parameters as $parameter) {
            $result[$parameter->key] = $parameter->value;
        }

        return $result;
    }
}
