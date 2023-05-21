<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

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
            response()->json(['message' => 'error', 'data' => $errors], 422)
        );
    }
}
