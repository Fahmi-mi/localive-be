<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class WhatsappNumberResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'label' => $this->translatable('label'),
            'status' => $this->status,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
