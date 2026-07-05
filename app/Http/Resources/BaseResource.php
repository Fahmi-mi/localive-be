<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Return the full translatable object {id, en} for a given field.
     * Falls back to 'id' if the field is missing or not JSON.
     */
    protected function translatable(string $field): array
    {
        $value = $this->resource->getAttribute($field);

        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            }
        }

        if (! is_array($value)) {
            return [
                'id' => (string) $value,
                'en' => (string) $value,
            ];
        }

        return [
            'id' => $value['id'] ?? '',
            'en' => $value['en'] ?? ($value['id'] ?? ''),
        ];
    }
}
