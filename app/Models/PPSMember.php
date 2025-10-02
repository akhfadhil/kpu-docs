<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PPSMember extends Model {

    use HasFactory;
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