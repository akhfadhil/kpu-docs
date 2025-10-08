<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model {

    use HasFactory;
    protected $table = 'kecamatan';
    protected $fillable = ['name'];

    protected static function booted()
    {
        static::created(function ($kecamatan) {
            // Buat anggota PPK
            $ppk = \App\Models\PPKMember::create([
                'name' => 'PPK ' . $kecamatan->name,
                'job_title' => 'Ketua PPK',
                'kecamatan_id' => $kecamatan->id,
            ]);

            // Buat user untuk PPK
            $ppk->user()->create([
                'name' => $ppk->name,
                'username' => 'ppk' . $kecamatan->id,
                'email' => 'ppk' . $kecamatan->id . '@example.com',
                'password' => bcrypt('password'),
                'role_id' => \App\Models\Role::where('role', 'ppk')->first()->id,
            ]);
        });
    }

    public function desa() { 
        return $this->hasMany(Desa::class); 
    }

    public function ppk_member() { 
        return $this->hasMany(PPKMember::class); 
    }
    
    public function document() { 
        return $this->morphMany(Document::class, 'documentable'); 
    }
}