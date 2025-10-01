<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model {
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
        return $this->morphMany(Document::class, 'dokumenable'); 
    } // if desa can upload
}