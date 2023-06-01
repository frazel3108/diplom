<?php

namespace App\Http\Requests\Admin\Product;

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
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string',
            'url' => [
                'nullable',
                Rule::unique('products')->ignore($this->product),
            ],
            'description' => 'nullable',
            'price' => 'required',
            'sale_price' => 'nullable',
            'popular' => 'nullable',
            'order' => 'nullable|integer',
            'images.*' => 'nullable',
            'offers' => 'nullable|array',
            'offers.*' => 'exists:offers,id',
            'characteristic' => 'nullable|array',
            'characteristic.id.*' => 'nullable|exists:characteristics,id',
            'characteristic.value.*' => 'nullable',
        ];

        $images = $this->image ? count($this->image) - 1 : 0;
        if ($images > 0) {
            foreach (range(0, $images) as $image) {
                $rules['image.' . $image] = 'file|mimetypes:image/*';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Не заполнено обязательное поле "Родительская категория".',
            'category_id.integer' => 'Поле "Родительская категория" должно быть числом.',
            'name.required' => 'Не заполнено обязательное поле "Название категории".',
            'name.string' => 'Поле "Название категории" должно быть строкой.',
            'url.string' => 'Поле "Url" должно быть строкой.',
            'url.unique' => 'Поле "Url" должно быть уникальным.',
            'price.required' => 'Не заполнено обязательное поле "Цена без скидки".',
            'order.integer' => 'Поле "Приоритет" должно быть числом.',
            'images.*.mimetypes' => 'Загружен неверный формат изображения.',
        ];
    }
}