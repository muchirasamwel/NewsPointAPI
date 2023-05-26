<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

trait FormRequestValidationErrorTrait
{
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            Http::error(null, $errors, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
