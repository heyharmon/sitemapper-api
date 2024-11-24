<?php

namespace DDD\Domain\Websites\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'url' => $this->url,
            'page_count' => $this->page_count,
            'rank' => $this->rank,
            'design_rating' => $this->design_rating,
            'screenshot_url' => $this->screenshot_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
