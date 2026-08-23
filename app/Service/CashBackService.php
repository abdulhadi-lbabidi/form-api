<?php

namespace App\Service;

use App\Models\Cashback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CashBackService
{

  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::callback('search', function ($query, $value) {
        $query->where('company_name', 'like', "%{$value}%")
          ->orWhere('reasone', 'like', "%{$value}%");
      }),

      AllowedFilter::callback('category_id', function ($query, $value) {
        $query->whereHas('categories', function ($q) use ($value) {
          $q->where('cashback_categories.id', $value);
        });
      }),
    ];

    $query = QueryBuilder::for(Cashback::class)
      ->with(['categories'])
      ->allowedFilters(...$filters)
      ->allowedSorts(
        'created_at',
        'id',
        'company_name',
        'number_of_clicks'
      )
      ->defaultSort('-created_at');

    if ($paginate) {
      return $query->paginate(
        perPage: $perPage,
        page: $page,
        columns: $columns,
      );
    }

    return $query->get($columns);
  }

  public function findOne(Cashback $cashback): Cashback
  {
    return $cashback->load(['categories']);
  }
  public function incrementClickAndGetUrl(Cashback $cashback): ?string
  {
    $cashback->increment('number_of_clicks');

    return $cashback->redirect_url;
  }
}
