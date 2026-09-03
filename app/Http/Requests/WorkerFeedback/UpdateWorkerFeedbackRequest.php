<?php

namespace App\Http\Requests\WorkerFeedback;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkerFeedbackRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return false;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'worker_id'         => ['sometimes', 'required', 'integer', 'exists:workers,id'],
      'stars'             => ['nullable', 'numeric', 'min:0', 'max:5'],
      'reason'            => ['nullable', 'string'],
      'feedbackable_type' => ['sometimes', 'required', 'string', 'in:App\Models\Company,App\Models\Kadr,App\Models\User'],
      'feedbackable_id'   => ['sometimes', 'required', 'integer'],
    ];
  }
}
