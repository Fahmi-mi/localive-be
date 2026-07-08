<?php

namespace App\Http\Requests\Content;

use App\Rules\ValidImage;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePartnerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo' => ['nullable', new ValidImage],
            'remove_logo' => ['sometimes', 'boolean'],
            'name.id' => ['required', 'string'],
            'name.en' => ['nullable', 'string'],
            'description.id' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],
        ];
    }
}
