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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // 💡 လက်ရှိ ပြင်ဆင်နေတဲ့ Student ရဲ့ ID ကို လှမ်းယူတာပါ
        $studentId = $this->route('student') ?? $this->id; 

        return [
            // 💡 Create လုပ်ချိန်မှာပဲ ပုံလိုအပ်ပြီး Update လုပ်ချိန်မှာ ပုံမရွေးလည်း ရအောင် nullable ပြောင်းထားပါတယ်
            'image' => $studentId ? 'nullable|file|mimes:png,jpg,jpeg|max:5120' : 'required|file|mimes:png,jpg,jpeg|max:5120',
            
            // 💡 လက်ရှိကျောင်းသား ID ရဲ့ နာမည်၊ ဖုန်း၊ အီးမေးလ်တွေကို Ignore (ချန်လှပ်) ပေးထားပါတယ်
            'name' => ['required', Rule::unique('students', 'name')->ignore($studentId)],
            'class' => 'required',
            
            'email' => [
                'required',
                'email',
                Rule::unique('students', 'email')->ignore($studentId),
                Rule::unique('teachers', 'email') // ဆရာတွေရဲ့ email နဲ့လည်း သွားမတူရဘူး
            ],
            
            'phone' => [
                'required',
                'min:11',
                'max:11',
                Rule::unique('students', 'phone')->ignore($studentId),
                Rule::unique('teachers', 'phone')
            ],
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'we need Actual mail'
        ];
    }
}