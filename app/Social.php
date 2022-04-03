<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Napopravku\SuperDB\Models\PopularLinkSection
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property Service[] $services
 */
class Social extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
