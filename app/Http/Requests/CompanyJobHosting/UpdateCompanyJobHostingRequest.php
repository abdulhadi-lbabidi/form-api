<?php

namespace App\Http\Requests\CompanyJobHosting;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyJobHostingRequest extends FormRequest
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
      'company_id'       => ['sometimes', 'integer', 'exists:companies,id'],
      'title'            => ['sometimes', 'string', 'max:255'],
      'job_type'         => ['sometimes', 'string', 'max:255'],
      'workers_count'    => ['sometimes', 'integer', 'min:1'],
      'shift_period'     => ['sometimes', 'string', 'max:255'],
      'time_from'        => ['nullable', 'date_format:H:i'],
      'time_to'          => ['nullable', 'date_format:H:i'],
      'city'             => ['sometimes', 'string', 'max:255'],
      'district'         => ['nullable', 'string', 'max:255'],
      'experience_level' => ['sometimes', 'string', 'max:255'],
      'salary_min'       => ['nullable', 'numeric', 'min:0'],
      'salary_max'       => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
      'currency'         => ['sometimes', 'string', 'max:50'],
      'salary_interval'  => ['sometimes', 'string', 'max:50'],
      'notes'            => ['nullable', 'string'],
      'status'           => ['nullable', 'string', 'max:50'],
    ];
  }
}
