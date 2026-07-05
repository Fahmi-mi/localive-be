<?php

namespace App\Models;

use App\Models\Concerns\HasDraftActions;
use App\Models\Concerns\HasPublished;
use App\Models\Concerns\HasTranslatableFields;
use App\Models\Concerns\ValidatesPublishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VillageInfo extends Model
{
    use HasTranslatableFields, HasPublished, HasDraftActions, ValidatesPublishable, SoftDeletes;

    protected $table = 'village_info';

    public $translatable = ['background', 'vision', 'mission'];

    protected $fillable = ['background', 'vision', 'mission', 'status'];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get or create the singleton village info record.
     */
    public static function singleton(): self
    {
        return static::withoutGlobalScope(PublishedScope::class)->firstOrCreate(
            [],
            [
                'background' => json_encode(['id' => '', 'en' => '']),
                'vision' => json_encode(['id' => '', 'en' => '']),
                'mission' => json_encode(['id' => '', 'en' => '']),
            ]
        );
    }
}
