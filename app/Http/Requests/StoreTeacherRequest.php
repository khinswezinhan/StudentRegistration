<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'name' => 'required',
        'rank' => 'required',
        'email' => 'required|email|unique:students,email',
        'phone' => 'required',
        'address' => 'required',
        'image' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:5120',
        ];
    }
}
