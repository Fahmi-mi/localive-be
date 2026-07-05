<?php

namespace App\Http\Requests\Content;

use App\Rules\ValidImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', Rule::exists('article_categories', 'id')],
            'title.id' => ['required', 'string'],
            'title.en' => ['nullable', 'string'],
            'content.id' => ['required', 'string'],
            'content.en' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'image' => ['nullable', new ValidImage],
        ];
    }
}
