<?php

namespace App\Http\Requests\Kadr;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKadrRequst extends FormRequest
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
    $routeKadr = $this->route('kadr');


    $kadrId = $routeKadr instanceof \App\Models\Kadr
      ? $routeKadr->id
      : $routeKadr;



    return [
      'first_name' => [
        'sometimes',
        'required',
        'string',
        'max:255'
      ],

      'last_name' => [
        'sometimes',
        'required',
        'string',
        'max:255'
      ],

      'father_name' => [
        'sometimes',
        'required',
        'string',
        'max:255'
      ],

      'name' => [
        'sometimes',
        'required',
        'string',
        'max:255'
      ],

      'date_of_birth' => [
        'nullable',
        'date'
      ],

      'number_of_person' => [
        'nullable',
        'integer'
      ],

      'email' => [
        'sometimes',
        'required',
        'email',

        Rule::unique('kadrs', 'email')
          ->ignore($kadrId),
      ],

      'phone' => [
        'sometimes',
        'required',
        'string',

        Rule::unique('kadrs', 'phone')
          ->ignore($kadrId),
      ],

      'password' => [
        'nullable',
        'string',
        'min:6'
      ],

      'shop_address' => [
        'nullable',
        'string',
        'max:255'
      ],

      'city' => [
        'nullable',
        'string',
        'max:255'
      ],

      'residential_area' => [
        'nullable',
        'string',
        'max:255'
      ],

      'service_type' => [
        'nullable',
        'string',
        'max:255'
      ],

      'has_team' => [
        'nullable',
        'boolean'
      ],

      'social_or_website_link' => [
        'nullable',
        'string',
        'max:255'
      ],

      'image' => [
        'nullable',
        'array'
      ],

      'image.*' => [
        'file',
        'max:4096',
        'mimes:jpeg,jpg,png,pdf,doc,docx,txt'
      ],

      'deleted_media_ids' => [
        'nullable',
        'array'
      ],

      'deleted_media_ids.*' => [
        'integer',
        'exists:media,id'
      ],

      'marketing_source_ids' => [
        'nullable',
        'array'
      ],

      'marketing_source_ids.*' => [
        'integer',
        'exists:marketing_sources,id'
      ],
    ];
  }
}
