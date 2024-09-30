<?php

namespace DDD\Domain\Websites\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DDD\Domain\Pages\Resources\PageResource;
use DDD\Domain\Base\Files\Resources\FileResource;

class WebsiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'domain' => $this->domain,
            'page_count' => $this->pages->count(),
            'screenshot_url' => $this->screenshot_url,
            // 'screenshot' => new FileResource($this->screenshot),
            // 'favicon' => new FileResource($this->favicon),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
