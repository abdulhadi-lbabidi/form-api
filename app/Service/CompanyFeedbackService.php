<?php

namespace App\Service;

use App\Models\CompanyFeedback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyFeedbackService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::exact('company_id'),
      AllowedFilter::exact('stars'),
      AllowedFilter::exact('feedbackable_type'),
      AllowedFilter::exact('feedbackable_id'),

      AllowedFilter::callback('search', function ($query, $value) {
        $query->where(function ($q) use ($value) {
          $q->where('reason', 'like', "%{$value}%");
        });
      }),
    ];

    $query = QueryBuilder::for(CompanyFeedback::class)
      ->with(['company', 'feedbackable'])
      ->allowedFilters(...$filters)
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

  public function create(array $data): CompanyFeedback
  {
    return DB::transaction(function () use ($data) {
      return CompanyFeedback::create($data);
    });
  }

  public function findOne(int $id): CompanyFeedback
  {
    return CompanyFeedback::with(['company', 'feedbackable'])->findOrFail($id);
  }

  public function update(CompanyFeedback $companyFeedback, array $data): CompanyFeedback
  {
    return DB::transaction(function () use ($companyFeedback, $data) {
      $companyFeedback->update($data);
      return $companyFeedback;
    });
  }

  public function delete(CompanyFeedback $companyFeedback): bool
  {
    return DB::transaction(function () use ($companyFeedback) {
      return $companyFeedback->delete();
    });
  }
}
