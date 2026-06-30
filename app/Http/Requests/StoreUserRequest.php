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
    // 💡 လက်ရှိ Route ထဲကလာတဲ့ user id ကို လှမ်းယူခြင်း
    // ရိုးရိုး route('user') သို့မဟုတ် route('id') မင်းရဲ့ route parameter ပေါ်မူတည်ပြီး ယူပေးရပါမယ်
    $userId = $this->route('user') ?? $this->route('id');

    return [
        'name' => ['required', 'string', 'max:255'],
        
        // 💡 email rules ကို အခုလို ပြောင်းလဲပေးပါ
        'email' => [
            'required', 
            'string', 
            'email', 
            'max:255', 
            'unique:users,email,' . $userId // 👈 လက်ရှိ ID ကို ignore လုပ်ခိုင်းတဲ့အပိုင်း
        ],
        
        // password က edit အချိန်မှာ မရိုက်လည်းရအောင် nullable ပေးထားမယ်
        'password' => ['nullable', 'string', 'min:8'],
        'role_id' => ['required', 'exists:roles,id'],
        'status' => ['nullable', 'string', 'in:active,inactive'],
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
