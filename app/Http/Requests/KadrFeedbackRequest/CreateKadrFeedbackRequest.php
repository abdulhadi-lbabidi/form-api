<?php

namespace App\Http\Requests\KadrFeedbackRequest;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateKadrFeedbackRequest extends FormRequest
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
      'kadr_id'           => ['required', 'integer', 'exists:kadrs,id'],
      'stars'             => ['nullable', 'numeric', 'min:0', 'max:5'],
      'reason'            => ['nullable', 'string'],
      'feedbackable_type' => ['required', 'string', 'in:App\Models\Company,App\Models\Worker,App\Models\User'],
      'feedbackable_id'   => ['required', 'integer'],
    ];
  }
}