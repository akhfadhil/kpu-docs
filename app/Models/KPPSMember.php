<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KPPSMember extends Model {
    public function tps() { 
        return $this->belongsTo(TPS::class); 
    }
    public function user() { 
        return $this->morphOne(User::class, 'userable'); 
    } // optional
    public function document()
    {
        return $this->hasMany(Document::class);
    }
}