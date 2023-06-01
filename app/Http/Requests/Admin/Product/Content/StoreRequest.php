<?php

namespace App\Http\Requests\Admin\Product\Content;

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
            'product_id' => 'required|integer|exists:products,id',
            'type'  => 'required|string',
            'content' => 'nullable',
            'file' => 'nullable|file'
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Не заполнено обязательное поле "Товар".',
            'type.required' => 'Не выбран тип загружаемого поля.',
        ];
    }
}