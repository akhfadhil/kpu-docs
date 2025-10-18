<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model 
{

    use HasFactory;
    protected $table = 'documents';
    protected $fillable = ['doc_type', 'path', 'uploaded_by'];


    public function documentable() 
    { 
        return $this->morphTo(); 
    }
    
    public function uploader() 
    { 
        return $this->belongsTo(User::class, 'uploaded_by'); 
    }
}