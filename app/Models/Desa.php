<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desa extends Model {

    use HasFactory;
    protected $table = 'desa';

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