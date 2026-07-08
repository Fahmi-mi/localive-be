<?php

namespace App\Models;

use App\Models\Concerns\HasDraftActions;
use App\Models\Concerns\HasPublished;
use App\Models\Concerns\HasTranslatableFields;
use App\Models\Concerns\ValidatesPublishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasTranslatableFields, HasPublished, HasDraftActions, ValidatesPublishable, SoftDeletes;

    public $translatable = ['business_name', 'owner', 'location'];

    protected $fillable = [
        'business_name', 'owner', 'founded_date', 'location',
        'phone', 'email', 'ig_url', 'yt_url', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'founded_date' => 'date',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get or create the singleton profile record.
     */
    public static function singleton(): self
    {
        return static::withoutGlobalScope(PublishedScope::class)->firstOrCreate(
            [],
            [
                'business_name' => json_encode(['id' => '', 'en' => '']),
                'owner' => json_encode(['id' => '', 'en' => '']),
                'location' => json_encode(['id' => '', 'en' => '']),
            ]
        );
    }
}
