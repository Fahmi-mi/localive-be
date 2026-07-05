<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUmkmCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name.id' => ['required', 'string'],
            'name.en' => ['nullable', 'string'],
            'slug' => [
                'required',
                'string',
                Rule::unique('umkm_categories', 'slug')->ignore($this->route('umkm_category')),
            ],
        ];
    }
}
