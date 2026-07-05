<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTourCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name.id' => ['required', 'string'],
            'name.en' => ['nullable', 'string'],
            'slug' => ['required', 'string', Rule::unique('tour_categories', 'slug')],
        ];
    }
}
