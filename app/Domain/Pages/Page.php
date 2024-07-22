<?php

namespace DDD\Domain\Pages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDD\Domain\Websites\Website;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
