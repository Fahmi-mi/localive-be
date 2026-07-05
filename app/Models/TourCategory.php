<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableFields;
use Illuminate\Database\Eloquent\Model;

class TourCategory extends Model
{
    use HasTranslatableFields;

    public $translatable = ['name'];

    protected $fillable = ['name', 'slug'];
}
