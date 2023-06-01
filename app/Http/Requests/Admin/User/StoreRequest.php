<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Не заполнено обязательное поле "Имя".',
            'email.required' => 'Не заполнено обязательное поле "Email address".',
            'email.unique' => 'Значение поля "Email address" уже занято.',
            'phone.required' => 'Не заполнено обязательное поле "Номер телефона".',
            'phone.unique' => 'Значение поля "Номер телефона" уже занято.',
            'password.required' => 'Не заполнено обязательное поле "Пароль".',
            'password.min' => 'Поле "Пароль" должно быть больше 7 символов.',
        ];
    }
}
