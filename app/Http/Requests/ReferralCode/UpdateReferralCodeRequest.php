<?php

namespace App\Http\Requests\ReferralCode;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReferralCodeRequest extends FormRequest
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
    $referralCodeId = $this->route('referral_code');

    return [
      'referralable_id'   => ['sometimes', 'required', 'integer'],
      'referralable_type' => ['sometimes', 'required', 'string'],
      'code'              => [
        'sometimes',
        'required',
        'string',
        'max:50',
        Rule::unique('referral_codes', 'code')->ignore($referralCodeId)
      ],
      'usage_limit'       => ['nullable', 'integer', 'min:1'],
      'times_used'        => ['sometimes', 'required', 'integer', 'min:0'],
      'expires_at'        => ['nullable', 'date', 'after_now'],
      'is_active'         => ['sometimes', 'required', 'boolean'],
    ];
  }
}