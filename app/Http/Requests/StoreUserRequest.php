<?php

namespace App\Http\Requests;

use App\Traits\FormRequestValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    use FormRequestValidationErrorTrait;

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
}
