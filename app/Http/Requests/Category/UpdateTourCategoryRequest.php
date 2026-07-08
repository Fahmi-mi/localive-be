<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTourCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name.id' => ['required', 'string'],
            'name.en' => ['nullable', 'string'],
            'slug' => [
                'required',
                'string',
                Rule::unique('tour_categories', 'slug')->ignore($this->route('tour_category')),
            ],
        ];
    }
}
