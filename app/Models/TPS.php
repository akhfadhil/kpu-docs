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

    // protected static function booted()
    // {
    //     static::created(function ($tps) {
    //         $kpps = \App\Models\KPPSMember::create([
    //             'name' => 'KPPS ' . $tps->tps_code,
    //             'job_title' => 'Ketua KPPS',
    //             'tps_id' => $tps->id,
    //         ]);

    //         $kpps->user()->create([
    //             'name' => $kpps->name,
    //             'username' => 'kpps' . $tps->id,
    //             'email' => 'kpps' . $tps->id . '@example.com',
    //             'password' => bcrypt('password'),
    //             'role_id' => \App\Models\Role::where('role', 'kpps')->first()->id,
    //         ]);
    //     });
    // }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function ketua_kpps()
    {
        return $this->hasOne(KPPSMember::class, "tps_id")->where(
            "job_title",
            "Ketua KPPS",
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
