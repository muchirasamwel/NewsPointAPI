<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            Http::error(null,$errors, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
