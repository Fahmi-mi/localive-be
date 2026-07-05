<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PartnerResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'logo' => $this->logo,
            'logo_url' => $this->logo ? url('storage/' . $this->logo) : null,
            'name' => $this->translatable('name'),
            'description' => $this->translatable('description'),
            'status' => $this->status,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
