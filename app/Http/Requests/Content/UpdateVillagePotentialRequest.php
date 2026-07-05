<?php

namespace App\Http\Requests\Content;

use App\Rules\ValidImage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVillagePotentialRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['nullable', new ValidImage],
            'title.id' => ['required', 'string'],
            'title.en' => ['nullable', 'string'],
            'description.id' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],
        ];
    }
}
