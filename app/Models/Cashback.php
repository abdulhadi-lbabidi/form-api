<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
  'company_name',
  'reasone',
  'number_of_clicks',
  'redirect_url',
  'is_favorite'
])]
class Cashback extends Model
{

  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
      'number_of_clicks' => 'integer',
    ];
  }


  public function categories(): BelongsToMany
  {
    return $this->belongsToMany(CashbackCategory::class, 'cashback_cashback_categories')
      ->withTimestamps();
  }
}
