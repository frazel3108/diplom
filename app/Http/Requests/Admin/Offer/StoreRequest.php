<?php

namespace App\Http\Requests\Admin\Offer;

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
            'href' => 'required|string|unique:offers,href',
            'percent' => 'required|integer|max:99|min:5',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
            'banner' => 'required|file|mimetypes:image/*',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Не заполнено обязательное поле "Название Акции".',
            'name.string' => 'Поле "Название Акции" должно быть строкой.',
            'href.required' => 'Не заполнено обязательное поле "Страница Акции".',
            'href.string' => 'Поле "Страница Акции" должно быть строкой.',
            'start_at.required' => 'Не заполнено обязательное поле "Дата начала акции".',
            'start_at.date' => 'Поле "Дата начала акции" должно быть типа даты.',
            'end_at.required' => 'Не заполнено обязательное поле "Дата окончания акции".',
            'end_at.date' => 'Поле "Дата окончания акции" должно быть типа даты.',
            'banner.mimetypes' => 'Загружен неверный формат изображения.',
            'percent.required' => 'Не заполнено обязательное поле "Процент скидки товара".',
            'percent.integer' => 'Поле "Процент скидки товара" должно быть числом.',
            'percent.max' => 'Максимальная скидка может быть 99%.',
            'percent.min' => 'Минимальная скидка может быть 5%.',
        ];
    }
}