<?php

namespace App\Http\Requests\Company;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
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
    $companyId = $this->route('company');

    return [
      'company_name'   => ['sometimes', 'required', 'string', 'max:255'],
      'city'                 => ['sometimes', 'required', 'string', 'max:255'],
      'business_type'  => ['sometimes', 'required', 'string', 'max:255'],
      'problems_faced' => ['nullable', 'string'],
      'work_location'  => ['sometimes', 'required', 'string', 'max:255'],
      'code' => ['nullable', 'string', 'max:255', 'unique:companies,code'],
      'is_verified' => ['nullable', 'boolean'],
      'email'          => [
        'sometimes',
        'required',
        'email',
        'max:255',
        Rule::unique('companies', 'email')->ignore($companyId)
      ],
      'phone_number'   => ['sometimes', 'required', 'string', 'max:20', Rule::unique('companies', 'phone_number')->ignore($companyId)],
      'owner_name'     => ['sometimes', 'required', 'string', 'max:255'],
      'contact_person_name'     => ['sometimes', 'required', 'string', 'max:255'],
      'form_referral_code' => ['nullable', 'string', 'max:255'],

      'image'   => ['nullable', 'array'],
      'image.*' => ['file', 'max:4096', 'mimes:jpeg,jpg,png,pdf,doc,docx,txt'],
    ];
  }
}
