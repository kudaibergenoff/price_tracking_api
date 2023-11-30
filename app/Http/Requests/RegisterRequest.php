<?php

namespace App\Http\Requests;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email:rfc', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя пользователя обязательное поле.',
            'email.required' => 'Адрес электронной почты обязательное поле.',
            'email.email' => 'Поле электронной почты должно быть действительным адресом электронной почты.',
            'email.unique' => 'Пользователь с данным адресом электронной почты уже зарегистрирован.',
            'password.required' => 'Пароль обязательное поле.',
            'password.min' => 'Длина пароля не менее 8 символов.',
            'password.confirmed' => 'Подтверждение поля пароля не совпадает.',
        ];
    }
}
