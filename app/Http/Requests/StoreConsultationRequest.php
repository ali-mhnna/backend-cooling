<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'service_type' => 'required|string|max:255',
            'project_details' => 'required|string|max:2000',
        ];
    }

    // تحقق إن واحد منهم موجود (phone أو email)
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->phone) && empty($this->email)) {
                $validator->errors()->add('phone', 'يجب إدخال رقم الهاتف أو البريد الإلكتروني');
                $validator->errors()->add('email', 'يجب إدخال رقم الهاتف أو البريد الإلكتروني');
            }
        });
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'الاسم الكامل مطلوب',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'service_type.required' => 'نوع الخدمة مطلوب',
            'project_details.required' => 'تفاصيل المشروع مطلوبة',
        ];
    }

    // إرجاع JSON عند فشل الـ validation
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'خطأ في البيانات المدخلة',
            'errors' => $validator->errors()
        ], 422));
    }
}