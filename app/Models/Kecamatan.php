<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model {
    public function desa() { 
        return $this->hasMany(Desa::class); 
    }
    public function ppk_member() { 
        return $this->hasMany(PPKMember::class); 
    }
    public function document() { 
        return $this->morphMany(Document::class, 'dokumenable'); 
    } // if kecamatan can upload
}