<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use App\Services\ImagePipelineService;

class ValidImage implements ValidationRule
{
    /**
     * Allowed MIME types for upload.
     */
    private const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    /**
     * Maximum file size in kilobytes.
     */
    private const MAX_SIZE_KB = ImagePipelineService::MAX_SIZE_KB;

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            return;
        }

        if (! $value->isValid()) {
            $fail('Gambar gagal diunggah, silakan coba lagi.');

            return;
        }

        // Validate MIME type
        if (! in_array($value->getMimeType(), self::ALLOWED_MIMES, true)) {
            $fail('Format gambar harus JPEG, PNG, atau WebP.');
        }

        // Validate file size (max 2MB)
        if ($value->getSize() > self::MAX_SIZE_KB * 1024) {
            $fail('Ukuran gambar maksimal 2MB.');
        }
    }
}
