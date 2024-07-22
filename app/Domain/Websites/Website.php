<?php

namespace DDD\Domain\Websites;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDD\Domain\Pages\Page;
use DDD\Domain\Funnels\FunnelStep;

class Website extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
