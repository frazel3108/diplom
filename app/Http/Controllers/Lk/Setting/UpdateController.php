<?php

namespace App\Http\Controllers\Lk\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lk\Setting\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    public function __invoke(User $user, UpdateRequest $request)
    {
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if (isset($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('lk.setting')->withStatus('Данные обновлены!');
    }
}