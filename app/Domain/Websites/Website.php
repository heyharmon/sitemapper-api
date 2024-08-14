<?php

namespace DDD\Domain\Websites;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use DDD\Domain\Websites\Actions\StoreWebsiteScreenshotAction;
use DDD\Domain\Websites\Actions\StoreWebsiteFaviconAction;
use DDD\Domain\Pages\Page;
use DDD\Domain\Base\Files\File;
use DDD\App\Services\Url\UrlService;

class Website extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [];

    public static function boot()
    {
        parent::boot();

        self::created(function (Website $website) {
            StoreWebsiteScreenshotAction::run($website);
            StoreWebsiteFaviconAction::run($website);
        });

        self::deleted(function (Website $website) {
            File::find($website->screenshot_file_id)->delete();
            File::find($website->favicon_file_id)->delete();
            // $website->screenshot()->delete();
            // $website->favicon()->delete();
        });
    }

    public function setDomainAttribute($value)
    {
        $this->attributes['domain'] = UrlService::getDomain($value);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function screenshot()
    {
        return $this->belongsTo(File::class, 'screenshot_file_id');
    }

    public function favicon()
    {
        return $this->belongsTo(File::class, 'favicon_file_id');
    }
}
