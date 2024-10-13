<?php

namespace DDD\Domain\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDD\Domain\Companies\Company;
use DDD\Domain\Contacts\Casts\ContactMetadataCast;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'metadata' => ContactMetadataCast::class,
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
