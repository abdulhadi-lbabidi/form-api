<?php

namespace App\Http\Requests\ApplyJob;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplyJobRequest extends FormRequest
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
      'jobable_type' => ['sometimes', 'string', 'in:App\Models\CompanyJobHosting,App\Models\KadrJobHosting'],
      'jobable_id'   => ['sometimes', 'integer'],
      'notes'        => ['nullable', 'string', 'max:1000'],
    ];
  }
}