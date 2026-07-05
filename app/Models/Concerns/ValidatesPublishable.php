<?php

namespace App\Models\Concerns;

use Illuminate\Validation\ValidationException;

trait ValidatesPublishable
{
    /**
     * Validate that all translatable fields have both languages filled.
     *
     * @throws ValidationException
     */
    public function validateForPublish(): void
    {
        $errors = [];

        foreach ($this->translatable as $field) {
            $id = $this->getTranslation($field, 'id', false);
            $en = $this->getTranslation($field, 'en', false);

            if (blank($id)) {
                $errors["{$field}.id"] = ['Bahasa Indonesia wajib diisi sebelum publish.'];
            }
            if (blank($en)) {
                $errors["{$field}.en"] = ['Bahasa Inggris wajib diisi sebelum publish.'];
            }
        }

        if (! empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
