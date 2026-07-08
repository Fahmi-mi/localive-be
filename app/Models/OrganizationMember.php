<?php

namespace App\Models;

use App\Models\Concerns\HasDraftActions;
use App\Models\Concerns\HasPublished;
use App\Models\Concerns\HasTranslatableFields;
use App\Models\Concerns\ValidatesPublishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationMember extends Model
{
    use HasTranslatableFields, HasPublished, HasDraftActions, ValidatesPublishable, SoftDeletes;

    public $translatable = ['name'];

    protected $fillable = ['image', 'name', 'status'];
}
