<?php

namespace DDD\Domain\Companies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDD\Domain\Websites\Website;
use DDD\Domain\Contacts\Contact;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
