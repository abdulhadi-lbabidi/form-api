<?php

namespace App\Service;

use App\Models\CashbackDeal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CashBackDealService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::callback('search', function ($query, $value) {
        $query->where('title', 'like', "%{$value}%")
          ->orWhere('content', 'like', "%{$value}%");
      }),
      AllowedFilter::exact('status'),
      AllowedFilter::exact('cashback_id'),
      AllowedFilter::callback('category_id', function ($query, $value) {
        $ids = is_array($value) ? $value : explode(',', $value);

        $query->whereHas('cashback.categories', function ($q) use ($ids) {
          $q->whereIn('cashback_categories.id', $ids);
        });
      }),
    ];

    $query = QueryBuilder::for(CashbackDeal::class)
      ->with(['cashback.categories'])
      ->allowedFilters(...$filters)
      ->allowedSorts(
        'created_at',
        'id',
        'start_date',
        'end_date',
        'comosion'
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

  public function findOne(CashbackDeal $cashbackDeal): CashbackDeal
  {
    return $cashbackDeal->load(['cashback']);
  }
}
