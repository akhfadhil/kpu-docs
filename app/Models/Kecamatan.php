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
            $roleId = \App\Models\Role::where("role", "ppk")->first()->id;

            // Buat 5 anggota PPK + usernya
            for ($i = 1; $i <= 5; $i++) {
                // Buat anggota PPK
                $ppk = \App\Models\PPKMember::create([
                    "name" => "PPK " . $kecamatan->name . " " . $i,
                    "job_title" => "PPK " . $i,
                    "kecamatan_id" => $kecamatan->id,
                ]);

                // Generate password random
                $randomPassword = Str::upper(Str::random(4)) . rand(10, 99);

                // Buat user
                $ppk->user()->create([
                    "name" => $ppk->name,
                    "username" =>
                        "ppk-" . Str::slug($kecamatan->name) . "-" . $i,
                    "password" => bcrypt($randomPassword),
                    "temporary_password" => $randomPassword,
                    "role_id" => $roleId,
                ]);
            }
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
