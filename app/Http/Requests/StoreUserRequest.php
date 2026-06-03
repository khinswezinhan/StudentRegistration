<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
    $userId = $this->route('id') ?? $this->route('user')?->id ?? $this->route('user'); 

    return [
        'name'     => 'required|string|min:3|max:255',
        
        'email'    => 'required|string|email|max:255|unique:users,email,' . $userId,
        
        'password' => $userId ? 'nullable|string|min:8' : 'required|string|min:8',
        
        'role_id'  => 'required|exists:roles,id',
    ];
}
}
