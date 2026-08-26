<?php

namespace App\Http\Requests\CompanyJobHosting;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyJobHostingRequest extends FormRequest
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
      'company_id'       => ['required', 'integer', 'exists:companies,id'],
      'title'            => ['required', 'string', 'max:255'],
      'job_type'         => ['required', 'string', 'max:255'],
      'workers_count'    => ['required', 'integer', 'min:1'],
      'shift_period'     => ['required', 'string', 'max:255'],
      'time_from'        => ['nullable', 'date_format:H:i'],
      'time_to'          => ['nullable', 'date_format:H:i'],
      'city'             => ['required', 'string', 'max:255'],
      'district'         => ['nullable', 'string', 'max:255'],
      'experience_level' => ['required', 'string', 'max:255'],
      'salary_min'       => ['nullable', 'numeric', 'min:0'],
      'salary_max'       => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
      'currency'         => ['required', 'string', 'max:50'],
      'salary_interval'  => ['required', 'string', 'max:50'],
      'notes'            => ['nullable', 'string'],
      'status'           => ['nullable', 'string', 'max:50'],
    ];
  }
}
