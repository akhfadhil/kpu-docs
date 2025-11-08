<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PPSMember extends Model
{
    use HasFactory;
    protected $table = "pps_member";
    protected $fillable = ["name", "job_title", "desa_id"];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, "userable");
    }

    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
