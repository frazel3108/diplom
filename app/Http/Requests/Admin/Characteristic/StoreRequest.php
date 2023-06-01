<?php

namespace App\Http\Requests\Admin\Characteristic;

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
            'name' => 'required|string',
            'is_multi' => 'nullable',
            'order' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Не заполнено обязательное поле "Название категории".',
            'name.string' => 'Поле "Название категории" должно быть строкой.',
            'order.integer' => 'Поле "Приоритет" должно быть числом.',
        ];
    }
}