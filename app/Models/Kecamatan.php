<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = "kecamatan";
    protected $fillable = ["name"];

    protected static function booted()
    {
        static::created(function ($kecamatan) {
            // Buat anggota PPK
            $ppk = \App\Models\PPKMember::create([
                "name" => "PPK " . $kecamatan->name,
                "job_title" => "PPK 1",
                "kecamatan_id" => $kecamatan->id,
            ]);

            $randomPassword = Str::upper(Str::random(4)) . rand(10, 99);

            // Buat user untuk PPK
            $ppk->user()->create([
                "name" => $ppk->name,
                "username" => "ppk-" . Str::slug($kecamatan->name),
                "password" => bcrypt($randomPassword),
                "temporary_password" => $randomPassword,
                "role_id" => \App\Models\Role::where("role", "ppk")->first()
                    ->id,
            ]);
        });
    }

    public function desa()
    {
        return $this->hasMany(Desa::class);
    }

    public function ppk_member()
    {
        return $this->hasMany(PPKMember::class);
    }

    public function document()
    {
        return $this->morphMany(Document::class, "documentable");
    }
}
