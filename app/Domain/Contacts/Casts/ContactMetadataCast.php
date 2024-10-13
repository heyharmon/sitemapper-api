<?php

namespace DDD\Domain\Contacts\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ContactMetadataCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $value = isset($value) ? json_decode($value, true) : [];

        $defaults = [
            'businessRegistrationEntityName' => null,
            'businessRegistrationAddress' => null,
            'businessRegistrationLastUpdated' => null,
        ];

        return array_merge($defaults, $value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        // Get the existing raw value of the attribute from the $attributes array
        $existingRaw = $attributes[$key] ?? null;

        // Decode the existing JSON data into an array
        $existing = isset($existingRaw) ? json_decode($existingRaw, true) : [];

        // Merge the existing data with the new data
        $merged = array_merge($existing, $value);

        // Encode the merged data back to JSON
        return json_encode($merged);
    }
}
