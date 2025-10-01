<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPSMember extends Model {

    protected $table = 'pps_member';

    public function desa() { 
        return $this->belongsTo(Desa::class); 
    }
    public function user() { 
        return $this->morphOne(User::class, 'userable'); 
    } // optional
    public function document()
    {
        return $this->hasMany(Document::class);
    }
}