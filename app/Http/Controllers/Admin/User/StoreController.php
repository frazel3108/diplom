<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use App\Http\Requests\Admin\User\StoreRequest;
use Illuminate\Support\Facades\Hash;

class StoreController
{
    public function __invoke(User $user, StoreRequest $request)
    {
        $validated = $request->validated();

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->password = Hash::make($validated['password']);

        $user->save();

        return redirect()->route('admin.user')
            ->withStatus('Пользователь создан!');
    }
}