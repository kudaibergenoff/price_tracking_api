<?php

namespace App\Http\Requests;

class UpdateProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'price' => ['required', 'between:0,99.99']
        ];
    }

    public function messages(): array
    {
        return [
            'price.required' => 'Цена товара обязательное поле.',
        ];
    }
}
