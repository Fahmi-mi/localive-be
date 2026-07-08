<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProfileResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'business_name' => $this->translatable('business_name'),
            'owner' => $this->translatable('owner'),
            'founded_date' => $this->founded_date?->format('Y-m-d'),
            'location' => $this->translatable('location'),
            'phone' => $this->phone,
            'email' => $this->email,
            'ig_url' => $this->ig_url,
            'yt_url' => $this->yt_url,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
