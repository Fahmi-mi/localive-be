<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class StoreWhatsappNumberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'number' => ['required', 'string', 'max:20'],
            'label.id' => ['required', 'string'],
            'label.en' => ['nullable', 'string'],
        ];
    }
}
