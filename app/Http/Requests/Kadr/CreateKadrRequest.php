<?php

namespace App\Http\Requests\Kadr;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateKadrRequest extends FormRequest
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
      'name'             => ['required', 'string', 'max:255'],
      'number_of_person' => ['nullable', 'integer'],
      'email'            => ['required', 'email', 'unique:kadrs,email'],
      'phone'            => ['required', 'string', 'unique:kadrs,phone'],
      'password'         => ['nullable', 'string', 'min:6'],
      'shop_address'     => ['nullable', 'string', 'max:255'],
      'city'             => ['nullable', 'string', 'max:255'],

      'marketing_source_ids'   => ['nullable', 'array'],
      'marketing_source_ids.*' => ['integer', 'exists:marketing_sources,id'],
    ];
  }
}
