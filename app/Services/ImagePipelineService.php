<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImagePipelineService
{
    /**
     * Maximum file size in kilobytes (2MB).
     */
    public const MAX_SIZE_KB = 2048;

    /**
     * Maximum image width in pixels.
     */
    public const MAX_WIDTH = 1200;

    /**
     * WebP compression quality (0-100).
     */
    public const QUALITY = 80;

    /**
     * Process an uploaded image through the full pipeline:
     * validate → resize → convert to webp → compress → save.
     *
     * @throws \InvalidArgumentException If the file exceeds 2MB.
     */
    public function process(UploadedFile $file, string $directory = ""): string
    {
        $this->validateSize($file);

        $image = Image::read($file)->scaleDown(width: self::MAX_WIDTH);

        $filename = $this->generateFilename();
        $path = $this->buildPath($directory, $filename);

        Storage::disk("public")->put($path, $image->toWebp(self::QUALITY));

        return $path;
    }

    /**
     * Delete an image from the public disk.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk("public")->exists($path)) {
            Storage::disk("public")->delete($path);
        }
    }

    /**
     * Replace an old image with a new one (deletes old, saves new).
     */
    public function replace(
        UploadedFile $file,
        string $directory,
        ?string $oldPath = null,
    ): string {
        $newPath = $this->process($file, $directory);
        $this->delete($oldPath);

        return $newPath;
    }

    /**
     * Get the full public URL for an image path.
     */
    public function url(?string $path): ?string
    {
        return $path ? Storage::disk("public")->url($path) : null;
    }

    /**
     * Validate that the file does not exceed the maximum size.
     *
     * @throws \InvalidArgumentException
     */
    private function validateSize(UploadedFile $file): void
    {
        if ($file->getSize() > self::MAX_SIZE_KB * 1024) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Ukuran file melebihi batas maksimal %dKB.",
                    self::MAX_SIZE_KB,
                ),
            );
        }
    }

    /**
     * Generate a unique filename with .webp extension.
     */
    private function generateFilename(): string
    {
        return uniqid("img_", true) . ".webp";
    }

    /**
     * Build the full storage path with optional subdirectory.
     */
    private function buildPath(string $directory, string $filename): string
    {
        $directory = trim($directory, "/");

        return $directory ? "{$directory}/{$filename}" : $filename;
    }
}
