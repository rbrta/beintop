<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'account_name',
        'user_id'
    ];

    protected $appends = [
        //'latest_order'
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'account_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return Model|HasMany|object|null
     */
    public function getLatestOrderAttribute()
    {
        return $this->orders()->where('paid_status', '!=', Order::STATUS_PENDING)->latest()->first();
    }
}
