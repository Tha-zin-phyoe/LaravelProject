<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;



use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class AttendanceRequest extends FormRequest
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
            'datetime' => 'required',
            'employee_id' => 'required|integer',
            // 'status'=>"nullable|default"
            
        ];
    }
    public function messages()
    {
        return [
            'datetime.required' => 'datetime is required',
            'employee_id.required' => 'employee_id is required',
           
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
