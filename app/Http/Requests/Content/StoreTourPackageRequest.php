<?php

namespace App\Http\Requests\Content;

use App\Rules\ValidImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTourPackageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', Rule::exists('tour_categories', 'id')],
            'title.id' => ['required', 'string'],
            'title.en' => ['nullable', 'string'],
            'description.id' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],
            'image' => ['nullable', new ValidImage],
        ];
    }
}
