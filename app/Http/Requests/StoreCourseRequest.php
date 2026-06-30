<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 💡 Request ကို ခွင့်ပြုရန်အတွက် true ပြောင်းပေးထားပါတယ်
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // 💡 Route parameter ထဲကလာမယ့် Course ID ကို ဖမ်းယူခြင်း (Update အချိန်မှာပဲ ရှိပါမယ်)
        $courseId = $this->route('course') ?? $this->route('id');

        return [
            // 💡 Create အချိန်မှာ unique စစ်ပြီး Update အချိန်မှာတော့ လက်ရှိ Course ID ကို ချွင်းချက်ပေးမယ့် Rule ပါ
            'course_name' => [
                'required', 
                'string', 
                'max:255', 
                'unique:courses,course_name,' . ($courseId ?? 'NULL') . ',id'
            ],
            
            'class_model_id' => ['required', 'exists:class_models,id'],
            'department_id' => ['required', 'exists:departments,id'],
            
            // 💡 ဖိုင်က unique ဖြစ်စရာမလိုတဲ့အပြင် Create/Update မှာ မတင်ဘဲကျော်လို့ရအောင် nullable ပေးထားပါတယ်
            'files' => ['nullable', 'array'], 
            'files.*' => ['file', 'mimes:pdf,doc,docx,zip,png,pptx,xlsx'],
        ];
    }
}