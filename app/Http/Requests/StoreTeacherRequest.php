<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        // 💡 လက်ရှိ Route ကနေ ပြင်မယ့် teacher ID ကို လှမ်းယူတာပါ
        $teacherId = $this->route('teacher') ?? $this->id; 

        return [
            'name' => ['required', 'min:2'],
            'rank' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('teachers', 'email')->ignore($teacherId), 
                Rule::unique('students', 'email')
            ],
            'phone' => [
                'required',
                'min:11',
                'max:11',
                Rule::unique('teachers', 'phone')->ignore($teacherId), // 💡 လက်ရှိဆရာ့ ဖုန်းဆိုရင် ကျော်ပေးမယ်
                Rule::unique('students', 'phone')
            ],
            'address' => 'required',
            'image' => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
            'department_id' => 'required|exists:departments,id',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
        ]; 
    }
}