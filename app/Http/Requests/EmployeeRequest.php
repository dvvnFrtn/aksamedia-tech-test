<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'position' => 'required',
            'phone' => 'required|numeric',
            'image' => 'required|image',
            'division_id' => 'required|uuid'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name field is required',
            'position.required' => 'position field is required',
            'division.required' => 'division field is required',
            'division.uuid' => 'division must be valid uuid value',
            'phone.required' => 'phone number is required',
            'phone.numeric' => 'phone number must be a numeric value',
            'image.required' => 'image is required',
            'image.image' => 'file uploaded must be an image',
        ];
    }
}
