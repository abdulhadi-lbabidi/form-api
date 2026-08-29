<?php

namespace App\Http\Requests\Kadr;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKadrRequst extends FormRequest
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
    $kadrId = $this->route('id') ?? $this->route('kadr');
    return [
      'name'             => ['sometimes', 'required', 'string', 'max:255'],
      'number_of_person' => ['nullable', 'integer'],
      'email'            => ['sometimes', 'required', 'email', Rule::unique('kadrs', 'email')->ignore($kadrId)],
      'phone'            => ['sometimes', 'required', 'string', Rule::unique('kadrs', 'phone')->ignore($kadrId)],
      'password'         => ['nullable', 'string', 'min:6'],
      'shop_address'     => ['nullable', 'string', 'max:255'],
      'city'             => ['nullable', 'string', 'max:255'],
    ];
  }
}
