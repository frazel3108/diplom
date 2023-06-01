<?php

namespace App\Http\Requests\Admin\Access;

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
        return [
            'name' => 'required|string',
            'key' => 'required|string',
            'Access.*' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'parent_id.required' => 'Не заполнено обязательное поле "Родительская категория".',
            'parent_id.integer' => 'Поле "Родительская категория" должно быть числом.',
            'name.required' => 'Не заполнено обязательное поле "Название категории".',
            'name.string' => 'Поле "Название категории" должно быть строкой.',
            'url.string' => 'Поле "Url" должно быть строкой.',
            'order.integer' => 'Поле "Приоритет" должно быть числом.',
            'image.mimetypes' => 'Загружен неверный формат изображения.',
        ];
    }
}
