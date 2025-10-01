<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model 
{
    protected $table = 'documents';

    public function documentable() 
    { 
        return $this->morphTo(); 
    }
    
    public function uploader() 
    { 
        return $this->belongsTo(User::class, 'uploaded_by'); 
    }
}