<?php

namespace App\Http\Requests\Content;

use App\Rules\ValidImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUmkmRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', Rule::exists('umkm_categories', 'id')],
            'title.id' => ['required', 'string'],
            'title.en' => ['nullable', 'string'],
            'description.id' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],
            'maps_link' => ['nullable', 'string', 'url'],
            'image' => ['nullable', new ValidImage],
        ];
    }
}
