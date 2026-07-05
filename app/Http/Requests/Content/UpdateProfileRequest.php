<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'business_name.id' => ['required', 'string'],
            'business_name.en' => ['nullable', 'string'],
            'owner.id' => ['required', 'string'],
            'owner.en' => ['nullable', 'string'],
            'founded_date' => ['nullable', 'date'],
            'location.id' => ['nullable', 'string'],
            'location.en' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'ig_url' => ['nullable', 'string', 'url'],
            'yt_url' => ['nullable', 'string', 'url'],
        ];
    }
}
