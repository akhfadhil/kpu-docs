<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KPPSMember extends Model {

    use HasFactory;
    protected $table = 'kpps_member';

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