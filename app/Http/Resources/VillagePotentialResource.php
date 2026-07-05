<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class VillagePotentialResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'image_url' => $this->image ? url('storage/' . $this->image) : null,
            'title' => $this->translatable('title'),
            'description' => $this->translatable('description'),
            'status' => $this->status,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
