<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name.id' => ['required', 'string'],
            'name.en' => ['nullable', 'string'],
            'slug' => ['required', 'string', Rule::unique('article_categories', 'slug')],
        ];
    }
}
