<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateUserProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('user_products')->where(function ($query) {
                    return $query->where('user_id', request()->user->id)
                        ->where('product_id', $this->product_id);
                }),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Идентификатор товара обязательное поле.',
            'product_id.exists' => 'Товар с таким идентификатором не существует.',
            'product_id.unique' => 'Пользователь уже подписан на этот товар.',
        ];
    }
}
