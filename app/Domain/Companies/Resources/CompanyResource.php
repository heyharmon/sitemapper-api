<?php

namespace DDD\Domain\Companies\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DDD\Domain\websites\Resources\WebsiteResource;
use DDD\Domain\Base\Files\Resources\FileResource;

class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'category' => $this->category,
            'website' => new WebsiteResource($this->website),
            'phone' => $this->phone,
            'address' => $this->address,
            'state' => $this->state,
            'city' => $this->city,
            'zip' => $this->zip,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'place_id' => $this->google_place_id,
            'google_rating' => $this->google_rating,
            'google_reviews' => $this->google_reviews,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
