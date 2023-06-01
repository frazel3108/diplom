<?php

namespace App\Http\Controllers\Support;

use App\Mail\DefaultMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormController
{
    public function __invoke(Request $request)
    {
        $data = $request->only(
            'email',
            'name',
            'message',
        );

        try {
            Mail::to(env('MAIL_ALWAYS_SEND_TO', 'tarasovandrey3108@yandex.ru'))
                ->send((new DefaultMail($data)));
        } catch (\Throwable $e) {
            return back()->withInput()
                ->withErrors('Произошла ошибка: ' . $e->getMessage());
        }

        return back()->withStatus('Форма успешно отправлена');
    }
}