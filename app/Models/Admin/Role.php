<?php

namespace App\Models\Admin;

use App\Enums\Admin\Access;
use App\Models\Admin\RoleAccess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    protected $table = 'admin__roles';

    public function roleAccess(Access $access): RoleAccess
    {
        return RoleAccess::where('admin__role_id', $this->id)
            ->where('admin__access_id', $access->value)
            ->first();
    }
}
