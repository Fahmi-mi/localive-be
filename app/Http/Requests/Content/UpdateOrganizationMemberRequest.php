<?php

namespace App\Http\Requests\Content;

use App\Rules\ValidImage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['nullable', new ValidImage],
            'name.id' => ['required', 'string'],
            'name.en' => ['nullable', 'string'],
        ];
    }
}
