<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UmkmResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'title' => $this->translatable('title'),
            'description' => $this->translatable('description'),
            'maps_link' => $this->maps_link,
            'phone' => $this->phone,
            'image' => $this->image,
            'image_url' => $this->image ? url('storage/' . $this->image) : null,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
