<?php

namespace App\Http\Requests\Worker;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateWorkerRequest extends FormRequest
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
      'first_name'           => ['required', 'string', 'max:255'],
      'last_name'            => ['required', 'string', 'max:255'],
      'father_name'          => ['required', 'string', 'max:255'],
      'mother_fullname'      => ['nullable', 'string', 'max:255'],
      'phone_whatsapp'       => ['required', 'string', 'max:20', 'unique:workers,phone_whatsapp'],
      'age' => ['required', 'date', 'before:today'],
      'city'                 => ['required', 'string', 'max:255'],
      'residential_area'     => ['required', 'string', 'max:255'],
      'marital_status'       => ['required', 'string', 'max:255'],
      'primary_profession'   => ['required', 'string', 'max:255'],
      'other_professions'    => ['nullable', 'string'],
      'work_hours'           => ['required', 'string', 'max:255'],
      'working_status'           => ['required', 'string', 'max:255'],
      'commitment_level'     => ['required', 'string', 'max:255'],
      'expected_hourly_rate_usd' => ['nullable', 'numeric', 'min:0'],
      'expected_hourly_rate_syp' => ['required', 'numeric', 'min:0'],
      'payment_method'       => ['required', Rule::in(['weekly', 'monthly'])],
      'code'                 => ['nullable', 'string', 'max:255', 'unique:workers,code'],
      'is_verified' => ['nullable', 'boolean'],
      'form_referral_code' => ['nullable', 'string', 'max:255'],

      'image'   => ['nullable', 'array'],
      'image.*' => ['file', 'max:4096', 'mimes:jpeg,jpg,png,pdf,doc,docx,txt'],
    ];
  }
}