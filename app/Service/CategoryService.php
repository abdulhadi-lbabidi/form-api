<?php

namespace App\Service;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryService
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

    $query = QueryBuilder::for(Category::class)
      ->withCount('workers')
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

  public function findOne(Category $category): Category
  {
    return $category->load(['workers']); // جلب تفاصيل التصنيف مع عماله المرتبطين
  }
}
