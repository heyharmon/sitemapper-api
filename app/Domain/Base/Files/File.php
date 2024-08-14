<?php

namespace DDD\Domain\Base\Files;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDD\App\Traits\BelongsToUser;
use DDD\App\Traits\BelongsToOrganization;

class File extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::deleted(function (File $file) {
            Storage::disk($file->disk)->delete($file->folder . '/' . $file->filename);
        });
    }

    public function getStorageUrl()
    {
        return config('cdn.cdn_url') . $this->path;
    }
}
