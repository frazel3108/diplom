<?php

namespace App\Models\Admin;

use App\Enums\Admin\Access;
use App\Enums\Admin\Level;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    use HasFactory;

    protected $table = 'admin__access_admin__role';

    protected $casts = [
        'info' => 'array',
        'admin__access_id' => Access::class,
        'level' => Level::class,
    ];
}
