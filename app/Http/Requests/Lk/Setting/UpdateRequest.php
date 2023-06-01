<?php

namespace App\Http\Requests\Lk\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->user()->id)
            ],
            'phone' => [
                'required',
                'max:11',
                Rule::unique('users')->ignore($this->user()->id)
            ],
        ];

        if (!is_null($this->new_password)) {
            $passwordRules = [
                'old_password' => 'required|current_password',
                'new_password' => 'required|confirmed|min:8|different:old_password'
            ];

            $rules = array_merge($rules, $passwordRules);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Не заполнено обязательное поле "Имя".',
            'name.max' => 'Максимальное значение поля "Имя" может быть 255 символов.',
            'email.required' => 'Не заполнено обязательное поле "Email".',
            'email.unique' => 'Поле "Email" должно быть уникальным.',
            'phone.required' => 'Не заполнено обязательное поле "Номер телефона".',
            'phone.unique' => 'Поле "Номер телефона" должно быть уникальным.',
            'old_password.required' => 'Не заполнено обязательное поле "Старый пароль".',
            'old_password.current_password' => 'Вы не верно указали ваш старый пароль.',
            'new_password.required' => 'Не заполнено обязательное поле "Новый пароль".',
            'new_password.confirmed' => 'Поле "Новый пароль" и "Подтверждение нового пароля" не совпадают!',
            'new_password.min' => 'Минимальное значение поля "Новый пароль" должно быть 8 символов.',
            'new_password.different' => 'Новый пароль должен отличаться от старого!',
        ];
    }
}