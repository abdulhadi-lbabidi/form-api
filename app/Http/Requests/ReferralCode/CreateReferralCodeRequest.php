<?php

namespace App\Http\Requests\ReferralCode;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateReferralCodeRequest extends FormRequest
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
      'referralable_id'   => ['required', 'integer'],
      'referralable_type' => ['required', 'string'],

      'code'              => ['required', 'string', 'max:50', 'unique:referral_codes,code'],
      'usage_limit'       => ['nullable', 'integer', 'min:1'],
      'times_used'        => ['nullable', 'integer', 'min:0'],
      'expires_at'        => ['nullable', 'date', 'after_now'],
      'is_active'         => ['nullable', 'boolean'],
    ];
  }
}
