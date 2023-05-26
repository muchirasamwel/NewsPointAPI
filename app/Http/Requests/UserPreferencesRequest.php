<?php

namespace App\Http\Requests;

use App\Traits\FormRequestValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class UserPreferencesRequest extends FormRequest
{
    use FormRequestValidationErrorTrait;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'user_id' => 'required|numeric',
            'user_preferences' => 'required|array'
        ];
    }
}
