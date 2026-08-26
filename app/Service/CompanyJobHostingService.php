<?php

namespace App\Service;

use App\Models\CompanyJobHosting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class CompanyJobHostingService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $query = QueryBuilder::for(CompanyJobHosting::class)
      ->with(['company'])
      ->allowedFilters(
        AllowedFilter::exact('company_id'),
        AllowedFilter::exact('city'),
        AllowedFilter::exact('job_type'),
        AllowedFilter::exact('district'),
        AllowedFilter::exact('status'),
        AllowedFilter::exact('experience_level'),
        AllowedFilter::partial('title')
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

  public function findOne(int $id): CompanyJobHosting
  {
    return CompanyJobHosting::with(['company'])->findOrFail($id);
  }

  public function create(array $data): CompanyJobHosting
  {
    return CompanyJobHosting::create($data);
  }

  public function update(CompanyJobHosting $companyJobHosting, array $data): CompanyJobHosting
  {
    $companyJobHosting->update($data);
    return $companyJobHosting;
  }

  public function delete(int $id): bool
  {
    $jobHosting = $this->findOne($id);
    return $jobHosting->delete();
  }
}
