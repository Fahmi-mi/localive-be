<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class VillageInfoResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vision' => $this->translatable('vision'),
            'mission' => $this->translatable('mission'),
            'status' => $this->status,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
