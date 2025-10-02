<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPKMember extends Model {

    use HasFactory;
    protected $table = 'ppk_member';
    // protected $fillable = ['nama', 'desa_id', ...];

    public function kecamatan() { 
        return $this->belongsTo(Kecamatan::class); 
    }

    public function user() { 
        return $this->morphOne(User::class, 'userable'); 
    } // optional

    public function document()
    {
        return $this->hasMany(Document::class);
    }

}