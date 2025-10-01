<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TPS extends Model {
    public function desa() { 
        return $this->belongsTo(Desa::class); 
    }
    public function kpps_member() { 
        return $this->hasMany(KPPSMember::class); 
    }
    public function document() { 
        return $this->morphMany(Document::class, 'dokumenable'); 
    }
}