<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Desa extends Model
{
    use HasFactory;
    protected $table = "desa";
    protected $fillable = ["name", "kecamatan_id"];

    protected static function booted()
    {
        static::created(function ($desa) {
            $pps = \App\Models\PPSMember::create([
                "name" => "PPS " . $desa->name,
                "job_title" => "PPS 1",
                "desa_id" => $desa->id,
            ]);

            $randomPassword = Str::upper(Str::random(4)) . rand(10, 99);

            $pps->user()->create([
                "name" => $pps->name,
                "username" => "pps-" . Str::slug($desa->name),
                "password" => bcrypt($randomPassword),
                "temporary_password" => $randomPassword,
                "role_id" => \App\Models\Role::where("role", "pps")->first()
                    ->id,
            ]);
        });
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function tps()
    {
        return $this->hasMany(TPS::class, "desa_id");
    }

    public function pps_member()
    {
        return $this->hasMany(PPSMember::class);
    }

    public function document()
    {
        return $this->morphMany(Document::class, "documentable");
    } // if desa can upload
}
