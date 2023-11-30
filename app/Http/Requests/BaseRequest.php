<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errorResponse = response()->json([
            'message' => 'Ошибка проверки',
            'errors'  => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($errorResponse);
    }

}
