<?php

namespace App\Http\Requests\Company;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
      'company_name'   => ['required', 'string', 'max:255'],
      'city'                 => ['required', 'string', 'max:255'],
      'business_type'  => ['required', 'string', 'max:255'],
      'problems_faced' => ['nullable', 'string'],
      'work_location'  => ['required', 'string', 'max:255'],
      'email'          => ['nullable', 'email', 'max:255', 'unique:companies,email'],
      'phone_number'   => ['required', 'string', 'max:20', 'unique:companies,phone_number'],
      'owner_name'     => ['required', 'string', 'max:255'],
      'contact_person_name'     => ['required', 'string', 'max:255'],
      'code' => ['nullable', 'string', 'max:255', 'unique:companies,code'],
      'is_verified' => ['nullable', 'boolean'],
      'form_referral_code' => ['nullable', 'string', 'max:255'],

      'image'   => ['nullable', 'array'],
      'image.*' => ['file', 'max:4096', 'mimes:jpeg,jpg,png,pdf,doc,docx,txt'],

      'marketing_source_ids'   => ['nullable', 'array'],
      'marketing_source_ids.*' => ['integer', 'exists:marketing_sources,id'],
    ];
  }
}
