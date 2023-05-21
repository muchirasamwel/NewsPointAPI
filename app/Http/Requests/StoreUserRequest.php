<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'firstname' => 'required|max:20',
            'lastname' => 'required|max:20',
            'email' => 'required|email|unique:users,email|max:30',
            'password' => 'required|min:8'
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
