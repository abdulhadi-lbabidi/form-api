<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSubscriptionRequest extends FormRequest
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
      'time_id' => ['required', 'integer', 'exists:times,id'],
      'status'  => ['required', 'string', 'max:255'],
      'note'    => ['nullable', 'string'],

      'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:' . now()->toDateString()],
      'subscribable_type' => [
        'required',
        'string',
        Rule::in(['App\Models\Company', 'App\Models\Worker'])
      ],

      'subscribable_id' => [
        'required',
        'integer',
        function ($attribute, $value, $fail) {
          $type = $this->input('subscribable_type');
          if ($type && class_exists($type)) {
            $exists = $type::where('id', $value)->exists();
            if (!$exists) {
              $fail('المشترك المحدد غير موجود في النظام.');
            }
          }
        }
      ],


    ];
  }
}
