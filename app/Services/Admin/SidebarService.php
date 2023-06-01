<?php

namespace App\Services\Admin;

use App\Facades\Admin\Sidebar;

class SidebarService
{
    public function getStructure(): array
    {
        require base_path('routes/admin/sidebar.php');

        return Sidebar::getStructure();
    }
}
