<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $studentId = $this->route('student') ?? $this->id; 

        return [
            'image' => $studentId ? 'nullable|file|mimes:png,jpg,jpeg|max:5120' : 'required|file|mimes:png,jpg,jpeg|max:5120',
            
            'name' => ['required', 'min:2', Rule::unique('students', 'name')->ignore($studentId)],
            
            // 💡 ပြင်ဆင်ချက်: 'class' နေရာမှာ 'class_model_id' လို့ပြောင်းပြီး exists rule ပါ ထည့်ပေးလိုက်ပါတယ်ဟေ့
            'class_model_id' => 'required|exists:class_models,id',
            
            'email' => [
                'required',
                'email',
                Rule::unique('students', 'email')->ignore($studentId),
                'unique:teachers,email', 
            ],
            
            'phone' => [
                'required',
                'digits:11', 
                Rule::unique('students', 'phone')->ignore($studentId),
                'unique:teachers,phone', 
            ],
            'address' => 'required',
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please fill Actual mail',
            'class_model_id.required' => 'Please select a class' // 💡 သပ်ရပ်အောင် message အသစ်လေး ထည့်ထားပေးတယ်
        ];
    }
}