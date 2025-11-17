<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPKMember extends Model
{
    use HasFactory;

    protected $table = "ppk_member";

    protected $fillable = ["name", "job_title", "kecamatan_id"];

    // Prevent infinite loop with user sync
    public $syncing = false;

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, "userable");
    }

    public function document()
    {
        return $this->hasMany(Document::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::updated(function ($ppk) {
            // Jika field name berubah & tidak dalam mode syncing & punya user
            if ($ppk->isDirty("name") && !$ppk->syncing && $ppk->user) {
                // Tandai bahwa kita sedang mensinkronkan
                $ppk->user->syncing = true;

                // Sync name ke user
                $ppk->user->name = $ppk->name;
                $ppk->user->save(); // WAJIB pakai save(), jangan update()
            }
        });
    }
}
