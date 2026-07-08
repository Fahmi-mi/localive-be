<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
{
    public function rules(): array
    {
        $adminId = $this->route('admin');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($adminId),
            ],
            'password' => $this->isMethod('put')
                ? ['nullable', 'string', Password::defaults()]
                : ['required', 'string', Password::defaults()],
            'role' => ['required', Rule::in(['super_admin', 'admin'])],
        ];
    }
}
