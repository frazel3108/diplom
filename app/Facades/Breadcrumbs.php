<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Utils\Breadcrumbs as Breads;

class Breadcrumbs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Breads::class;
    }
}
