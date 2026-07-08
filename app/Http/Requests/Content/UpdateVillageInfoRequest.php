<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVillageInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vision.id' => ['required', 'string'],
            'vision.en' => ['nullable', 'string'],
            'mission.id' => ['required', 'string'],
            'mission.en' => ['nullable', 'string'],
        ];
    }
}
