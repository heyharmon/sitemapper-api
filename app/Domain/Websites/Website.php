<?php

namespace DDD\Domain\Websites;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Casts\Attribute;
// use DDD\Domain\Websites\Actions\StoreWebsiteScreenshotAction;
// use DDD\Domain\Websites\Actions\StoreWebsiteFaviconAction;
use DDD\Domain\Pages\Page;
use DDD\Domain\Base\Files\File;
use DDD\App\Services\Url\UrlService;
// use DDD\App\Services\Screenshot\ThumbioService;

class Website extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     self::created(function (Website $website) {
    //         $screenshotter = new ThumbioService();

    //         $website->update([
    //             'screenshot_url' => $screenshotter->getScreenshot($website->domain)
    //         ]);

    //         // StoreWebsiteFaviconAction::run($website);
    //     });

    //     // self::deleted(function (Website $website) {
    //     //     File::find($website->screenshot_file_id)->delete();
    //     //     // File::find($website->favicon_file_id)->delete();
    //     // });
    // }

    // public function setDomainAttribute($value)
    // {
    //     // $this->attributes['domain'] = UrlService::getScheme($value) . '://' . UrlService::getHost($value);
    //     $this->attributes['domain'] = UrlService::getdomain($value);
    // }

    public function getScreenshotUrlAttribute()
    {
        return 'https://image.thum.io/get/auth/71004-cb31c5c1adfff09b79f63b9e3f4cb915/png/noanimate/wait/5/' . $this->url;
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    // public function screenshot()
    // {
    //     return $this->belongsTo(File::class, 'screenshot_file_id');
    // }

    // public function favicon()
    // {
    //     return $this->belongsTo(File::class, 'favicon_file_id');
    // }
}
