<?php

namespace App\Models;

use App\Models\Concerns\HasDraftActions;
use App\Models\Concerns\HasPublished;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasTranslatableFields;
use App\Models\Concerns\ValidatesPublishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourPackage extends Model
{
    use HasTranslatableFields, HasSlug, HasPublished, HasDraftActions, ValidatesPublishable, SoftDeletes;

    public $translatable = ['title', 'description'];

    protected $fillable = [
        'title', 'description', 'category_id', 'image', 'status',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class);
    }

    public function scopeByCategory($query, string $slug)
    {
        return $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
    }
}
