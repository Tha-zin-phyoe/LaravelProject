<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'expired_date' => 'nullable|string'
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'email.email' => 'Email must be email',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => true,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
