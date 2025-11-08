<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TPS extends Model
{
    use HasFactory;
    protected $table = "tps";
    protected $fillable = [
        "tps_code",
        "desa_id",
        "address",
        "number_of_voters",
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function ketua_kpps()
    {
        return $this->hasOne(KPPSMember::class, "tps_id")->where(
            "job_title",
            "KPPS 1",
        );
    }

    public function kpps_member()
    {
        return $this->hasMany(KPPSMember::class, "tps_id");
    }

    public function document()
    {
        return $this->morphMany(Document::class, "documentable");
    }
}
