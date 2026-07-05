<?php

namespace App\Http\Requests\Worker;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkerRequest extends FormRequest
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
    $workerId = $this->route('worker');
    return [
      'first_name'           => ['sometimes', 'required', 'string', 'max:255'],
      'last_name'            => ['sometimes', 'required', 'string', 'max:255'],
      'father_name'          => ['sometimes', 'required', 'string', 'max:255'],
      'mother_fullname'      => ['sometimes', 'required', 'string', 'max:255'],
      'phone_whatsapp'       => [
        'sometimes',
        'required',
        'string',
        'max:20',
        Rule::unique('workers', 'phone_whatsapp')->ignore($workerId)
      ],
      'age'                  => ['sometimes', 'required', 'integer', 'min:15', 'max:100'],
      'city'                 => ['sometimes', 'required', 'string', 'max:255'],
      'residential_area'     => ['sometimes', 'required', 'string', 'max:255'],
      'marital_status'       => ['sometimes', 'required', 'string', 'max:255'],
      'primary_profession'   => ['sometimes', 'required', 'string', 'max:255'],
      'other_professions'    => ['nullable', 'string'],
      'work_hours'           => ['sometimes', 'required', 'string', 'max:255'],
      'commitment_level'     => ['sometimes', 'required', 'string', 'max:255'],
      'expected_hourly_rate_usd' => ['sometimes', 'numeric', 'min:0'],
      'expected_hourly_rate_syp' => ['sometimes', 'numeric', 'min:0'],
      'payment_method'       => ['sometimes', 'required', Rule::in(['weekly', 'monthly'])],
      'code'                 => ['nullable', 'string', 'max:255', Rule::unique('workers', 'code')->ignore($workerId)],
      'is_verified' => ['nullable', 'boolean'],
      'form_referral_code' => ['nullable', 'string', 'max:255'],

      'image'          => ['nullable', 'image', 'max:4096'],

    ];
  }
}
