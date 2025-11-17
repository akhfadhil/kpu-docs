<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Attributes that can be mass-assigned.
     */
    protected $fillable = [
        "name",
        "username",
        "password",
        "temporary_password",
        "role_id",
        "userable_id",
        "userable_type",
    ];

    /**
     * Hide sensitive fields from serialization.
     */
    protected $hidden = ["password", "remember_token", "temporary_password"];

    /**
     * Casts.
     */
    protected function casts(): array
    {
        return [
            "password" => "hashed",
        ];
    }

    /**
     * Prevent infinite loop when syncing name with userable (PPKMember, etc.)
     */
    public $syncing = false;

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Polymorphic relation: User belongs to (PPKMember, PPSMember, KPPSMember, etc.)
     */
    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * User uploads documents
     */
    public function uploadedDokumen()
    {
        return $this->hasMany(Document::class, "uploaded_by");
    }

    public function isRole($roleName)
    {
        return $this->role && $this->role->role === $roleName;
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::updated(function ($user) {
            // Jika userable (model induk, ex: PPKMember) ada
            // dan name berubah
            // dan kita tidak sedang dalam mode syncing
            if ($user->isDirty("name") && !$user->syncing && $user->userable) {
                // Tandai kita sedang melakukan sync
                $user->userable->syncing = true;

                // Sync nama ke model induk (PPKMember, PPSMember, dsb.)
                $user->userable->name = $user->name;
                $user->userable->save(); // WAJIB save(), jangan update()
            }
        });
    }
}
