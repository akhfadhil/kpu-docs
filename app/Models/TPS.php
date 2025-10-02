<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TPS extends Model {

    use HasFactory;
    protected $table = 'tps';

    public function desa() { 
        return $this->belongsTo(Desa::class); 
    }
    public function kpps_member() { 
        return $this->hasMany(KPPSMember::class); 
    }
    public function document() { 
        return $this->morphMany(Document::class, 'documentable'); 
    }
}