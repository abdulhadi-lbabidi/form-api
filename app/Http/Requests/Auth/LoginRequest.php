<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
      'type'         => ['required', 'in:company,worker'],
      'login'        => ['required', 'string'],
      'password'     => ['required', 'string'],
    ];
  }

  public function messages(): array
  {
    return [
      'type.required'  => 'نوع المستخدم مطلوب (شركة أو عامل)',
      'type.in'        => 'نوع المستخدم غير صالح',
      'login.required' => 'حقل تسجيل الدخول (الهاتف أو البريد) مطلوب',
      'password.required' => 'كلمة المرور مطلوبة',
    ];
  }
}
