<?php

namespace App\Service;

use App\Models\CashbackCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CashbackCategoryService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::callback('search', function ($query, $value) {
        $query->where('name', 'like', "%{$value}%")
          ->orWhere('description', 'like', "%{$value}%");
      }),
    ];

    $query = QueryBuilder::for(CashbackCategory::class)
      ->withCount('cashbacks')
      ->allowedFilters(...$filters)
      ->allowedSorts(
        'created_at',
        'id',
        'name'
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

  public function findOne(CashbackCategory $cashbackCategory): CashbackCategory
  {
    return $cashbackCategory->load(['cashbacks']);
  }
}
