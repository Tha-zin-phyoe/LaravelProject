<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:admins',
            'name' => 'required|string',
            'photo'=>"nullable|string",
            // 'password' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'name.required' => 'Name is required',
            // 'password.required' => 'Password is required',
            'email.email' => 'Email must be email',
            'email.unique' => 'Email must be already exist!',
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
