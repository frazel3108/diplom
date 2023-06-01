<?php

namespace App\Http\Controllers\Lk\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        auth()->logout();
        $user->delete();

        return redirect()->route('index');
    }
}