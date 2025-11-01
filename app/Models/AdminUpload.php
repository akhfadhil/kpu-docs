<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AdminUpload extends Model
{
    protected $fillable = ["name"];

    public function document(): MorphMany
    {
        return $this->morphMany(Document::class, "documentable");
    }
}
