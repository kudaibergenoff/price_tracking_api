<?php

namespace App\Http\Requests;

class CreateProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:products,name'],
            'price' => ['required', 'between:0,99.99']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя товара обязательное поле.',
            'name.unique' => 'Такой товар уже существует.',
            'price.required' => 'Цена товара обязательное поле.',
        ];
    }
}
