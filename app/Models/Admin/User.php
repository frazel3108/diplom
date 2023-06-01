<?php

namespace App\Models\Admin;

use App\Enums\Admin\Access;
use App\Enums\Admin\Level;
use App\Models\Admin\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $table = 'admin__users';

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'admin__role_id');
    }

    public function hasAccess(Access $access, mixed $infoValue): bool
    {
        $roleAccess = $this->role->roleAccess($access);
        return match ($roleAccess->level) {
            Level::FULL_ACCESS => true,
            Level::PARTIAL_ACCESS => in_array($infoValue, $roleAccess->info),
            default => false
        };
    }
}
