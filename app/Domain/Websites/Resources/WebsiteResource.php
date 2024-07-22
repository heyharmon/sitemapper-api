<?php

namespace DDD\Domain\Websites\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DDD\Domain\Pages\Resources\PageResource;

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
            'pages' => PageResource::collection($this->pages),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
