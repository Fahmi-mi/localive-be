<?php

namespace App\Http\Requests\Content;

use App\Rules\ValidImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', Rule::exists('article_categories', 'id')],
            'title.id' => ['sometimes', 'required', 'string'],
            'title.en' => ['nullable', 'string'],
            'content.id' => ['sometimes', 'required', 'string'],
            'content.en' => ['nullable', 'string'],
            'date' => ['sometimes', 'date'],
            'image' => ['nullable', new ValidImage],
            'remove_image' => ['sometimes', 'boolean'],
        ];
    }
}
