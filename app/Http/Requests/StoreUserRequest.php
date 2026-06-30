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
        'name'     => 'required|string|min:2|max:255',
        
        'email' => [
    'required',
    'string',
    'max:255',
    // 💡 'email:rfc,dns' လို့ ပြောင်းလိုက်ရင် .com ပါမှရမယ်၊ တကယ့် internet ပေါ်က domain ဟုတ်မဟုတ်ပါ စစ်ပေးမှာပါဗျာ
    'email:rfc,dns', 
    'unique:users,email,'
],
        
 
        'password' =>  ['nullable', 'string', 'min:8', 'confirmed'], 
            
        
        'role_id'  => 'required|exists:roles,id',
    ];
}

public function messages(): array
{
    return [
        'password.required'  => 'Please fill out strong password ',
        'password.confirmed' => 'Confirm Password is not match with Password',
    ];
}
}
