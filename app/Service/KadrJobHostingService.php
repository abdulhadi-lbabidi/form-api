<?php

namespace App\Service;

use App\Models\KadrJobHosting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class KadrJobHostingService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $query = QueryBuilder::for(KadrJobHosting::class)
      ->with(['kadr', 'categories'])
      ->allowedFilters(
        AllowedFilter::exact('kadr_id'),
        AllowedFilter::exact('city'),
        AllowedFilter::exact('job_type'),
        AllowedFilter::exact('district'),
        AllowedFilter::exact('status'),
        AllowedFilter::exact('experience_level'),
        AllowedFilter::partial('title'),
        AllowedFilter::exact('categories', 'categories.id'),
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

  public function findOne(int $id): KadrJobHosting
  {
    return KadrJobHosting::with(['kadr'])->findOrFail($id);
  }

  public function create(array $data): KadrJobHosting
  {
    return KadrJobHosting::create($data);
  }

  public function update(KadrJobHosting $kadrJobHosting, array $data): KadrJobHosting
  {
    $kadrJobHosting->update($data);
    return $kadrJobHosting;
  }

  public function delete(int $id): bool
  {
    $jobHosting = $this->findOne($id);
    return $jobHosting->delete();
  }
}
