<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
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
      'time_id' => ['required', 'integer', 'exists:times,id'],
      'status'  => ['required', 'string', 'max:255'],
      'note'    => ['nullable', 'string'],
    ];
  }
}
