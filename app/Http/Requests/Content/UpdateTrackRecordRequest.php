<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRecordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content.id' => ['required', 'string'],
            'content.en' => ['nullable', 'string'],
        ];
    }
}
