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
            $roleId = \App\Models\Role::where("role", "pps")->first()->id;

            // Buat 3 anggota PPS + user-nya
            for ($i = 1; $i <= 3; $i++) {
                // Buat PPSMember
                $pps = \App\Models\PPSMember::create([
                    "name" => "PPS " . $desa->name . " " . $i,
                    "job_title" => "PPS " . $i,
                    "desa_id" => $desa->id,
                ]);

                // Generate password random
                $randomPassword = Str::upper(Str::random(4)) . rand(10, 99);

                // Buat User terkait
                $pps->user()->create([
                    "name" => $pps->name,
                    "username" => "pps-" . Str::slug($desa->name) . "-" . $i,
                    "password" => bcrypt($randomPassword),
                    "temporary_password" => $randomPassword,
                    "role_id" => $roleId,
                ]);
            }
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
    }
}
