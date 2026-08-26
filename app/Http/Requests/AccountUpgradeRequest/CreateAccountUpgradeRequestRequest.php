<?php

namespace App\Http\Requests\AccountUpgradeRequestResource;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountUpgradeRequestRequest extends FormRequest
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
      'morphable_type' => ['required', 'string', 'in:App\Models\Company,App\Models\Worker,App\Models\Kadr'],
      'morphable_id'   => ['required', 'integer'],
      'status'         => ['nullable', 'string', 'max:50'],
      'notes'          => ['nullable', 'string'],
    ];
  }
}