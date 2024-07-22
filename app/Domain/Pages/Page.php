<?php

namespace DDD\Domain\Pages;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use DDD\Domain\Websites\Website;
use DDD\App\Services\Url\UrlService;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [];

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = UrlService::getClean($value);
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = UrlService::getPath($value);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
