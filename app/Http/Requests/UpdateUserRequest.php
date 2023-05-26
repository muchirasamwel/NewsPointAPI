<?php

namespace App\Http\Requests;

use App\Traits\FormRequestValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    use FormRequestValidationErrorTrait;

    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }
}
