<?php

namespace App\Enums\Admin;

enum Access: int
{
    case CREATE = 1;
    case READ = 2;
    case UPDATE = 3;
    case DELETE = 4;
    case CREATE_USER = 5;
}
