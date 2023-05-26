<?php

namespace App\Http\Requests;

use App\Traits\FormRequestValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use FormRequestValidationErrorTrait;

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:30',
            'password' => 'required|min:8'
        ];
    }
}
