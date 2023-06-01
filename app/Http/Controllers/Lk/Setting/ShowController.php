<?php

namespace App\Http\Controllers\Lk\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $change = $request->get('change', '') == 'true' && $user->email_verified_at;

        return view('modules.lk.setting', compact('user', 'change'));
    }
}