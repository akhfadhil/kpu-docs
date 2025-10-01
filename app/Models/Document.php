<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model 
{
    public function dokumenable() 
    { 
        return $this->morphTo(); 
    }
    
    public function uploader() 
    { 
        return $this->belongsTo(User::class, 'uploaded_by'); 
    }
}