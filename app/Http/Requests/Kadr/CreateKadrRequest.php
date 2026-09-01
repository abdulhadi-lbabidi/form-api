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
      'first_name'             => ['required', 'string', 'max:255'],
      'last_name'              => ['required', 'string', 'max:255'],
      'father_name'            => ['required', 'string', 'max:255'],
      'name'                   => ['required', 'string', 'max:255'],
      'date_of_birth'          => ['nullable', 'date'],
      'number_of_person'       => ['nullable', 'integer'],
      'email'                  => ['required', 'email', 'unique:kadrs,email'],
      'phone'                  => ['required', 'string', 'unique:kadrs,phone'],
      'password'               => ['nullable', 'string', 'min:6'],
      'shop_address'           => ['nullable', 'string', 'max:255'],
      'city'                   => ['nullable', 'string', 'max:255'],
      'residential_area'       => ['nullable', 'string', 'max:255'],
      'service_type'           => ['nullable', 'string', 'max:255'],
      'has_team'               => ['nullable', 'boolean'],
      'social_or_website_link' => ['nullable', 'string', 'max:255'],

      'image'                  => ['nullable', 'array'],
      'image.*'                => ['file', 'max:4096', 'mimes:jpeg,jpg,png,pdf,doc,docx,txt'],

      'cv_file'                => ['nullable', 'file', 'max:5120', 'mimes:pdf,doc,docx'],

      'marketing_source_ids'   => ['nullable', 'array'],
      'marketing_source_ids.*' => ['integer', 'exists:marketing_sources,id'],
    ];
  }
}
