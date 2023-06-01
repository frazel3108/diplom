<?php

namespace App\Facades\Admin;

use Illuminate\Support\Facades\Facade;

class Sidebar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Utils\Admin\Sidebar\Sidebar::class;
    }
}
