<?php

namespace App\Models;

use App\Models\Concerns\HasDraftActions;
use App\Models\Concerns\HasPublished;
use App\Models\Concerns\HasTranslatableFields;
use App\Models\Concerns\ValidatesPublishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasTranslatableFields, HasPublished, HasDraftActions, ValidatesPublishable, SoftDeletes;

    public $translatable = ['name', 'description'];

    protected $fillable = ['logo', 'name', 'description', 'status'];
}
