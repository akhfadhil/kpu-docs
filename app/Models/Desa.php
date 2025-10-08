<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desa extends Model {

    use HasFactory;
    protected $table = 'desa';
    protected $fillable = ['name', 'kecamatan_id'];

    protected static function booted()
    {
        static::created(function ($desa) {
            $pps = \App\Models\PPSMember::create([
                'name' => 'PPS ' . $desa->name,
                'job_title' => 'Ketua PPS',
                'desa_id' => $desa->id,
            ]);

            $pps->user()->create([
                'name' => $pps->name,
                'username' => 'pps' . $desa->id,
                'email' => 'pps' . $desa->id . '@example.com',
                'password' => bcrypt('password'),
                'role_id' => \App\Models\Role::where('role', 'pps')->first()->id,
            ]);
        });
    }

    public function kecamatan() { 
        return $this->belongsTo(Kecamatan::class); 
    }

    public function tps() { 
        return $this->hasMany(TPS::class); 
    }

    public function pps_member() { 
        return $this->hasMany(PPSMember::class); 
    }
    
    public function document() { 
        return $this->morphMany(Document::class, 'documentable'); 
    } // if desa can upload
}