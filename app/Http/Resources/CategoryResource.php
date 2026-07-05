<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CategoryResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->translatable('name'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
