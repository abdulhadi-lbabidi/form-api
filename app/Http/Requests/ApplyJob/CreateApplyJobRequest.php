<?php

namespace App\Http\Requests\ApplyJob;

use Illuminate\Foundation\Http\FormRequest;

class CreateApplyJobRequest extends FormRequest
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
      'worker_id'    => ['required', 'integer', 'exists:workers,id'],
      'jobable_type' => ['required', 'string', 'in:App\Models\CompanyJobHosting,App\Models\KadrJobHosting'],
      'jobable_id'   => ['required', 'integer'],
      'notes'        => ['nullable', 'string', 'max:1000'],
    ];
  }
}
