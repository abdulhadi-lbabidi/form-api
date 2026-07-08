<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubscriptionRequest extends FormRequest
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
      'time_id' => ['sometimes', 'required', 'integer', 'exists:times,id'],
      'status'       => ['nullable', 'string', 'in:pending,active,canceled'],
      'note'    => ['nullable', 'string'],
      'phone_number' => ['sometimes', 'required', 'string', 'max:255'],
      'date' => ['sometimes', 'date', 'date_format:Y-m-d', 'after_or_equal:' . now()->toDateString()],
      // 'subscribable_type' => [
      //   'sometimes',
      //   'required',
      //   'string',
      //   Rule::in(['App\Models\Company', 'App\Models\Worker'])
      // ],
      // 'subscribable_id' => [
      //   'sometimes',
      //   'required',
      //   'integer',
      //   function ($attribute, $value, $fail) {
      //     $type = $this->input('subscribable_type') ?? $this->route('subscription')?->subscribable_type;
      //     if ($type && class_exists($type)) {
      //       $exists = $type::where('id', $value)->exists();
      //       if (!$exists) {
      //         $fail('المشترك المحدد غير موجود في النظام.');
      //       }
      //     }
      //   }
      // ],



    ];
  }
}
