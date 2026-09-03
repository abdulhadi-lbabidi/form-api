<?php

namespace App\Service;

use App\Models\KadrFeedback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class KadrFeedbackService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $filters = [
      AllowedFilter::exact('kadr_id'),
      AllowedFilter::exact('stars'),
      AllowedFilter::exact('feedbackable_type'),
      AllowedFilter::exact('feedbackable_id'),

      AllowedFilter::callback('search', function ($query, $value) {
        $query->where(function ($q) use ($value) {
          $q->where('reason', 'like', "%{$value}%");
        });
      }),
    ];

    $query = QueryBuilder::for(KadrFeedback::class)
      ->with(['kadr', 'feedbackable'])
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

  public function create(array $data): KadrFeedback
  {
    return DB::transaction(function () use ($data) {
      return KadrFeedback::create($data);
    });
  }

  public function findOne(int $id): KadrFeedback
  {
    return KadrFeedback::with(['kadr', 'feedbackable'])->findOrFail($id);
  }

  public function update(KadrFeedback $kadrFeedback, array $data): KadrFeedback
  {
    return DB::transaction(function () use ($kadrFeedback, $data) {
      $kadrFeedback->update($data);
      return $kadrFeedback;
    });
  }

  public function delete(KadrFeedback $kadrFeedback): bool
  {
    return DB::transaction(function () use ($kadrFeedback) {
      return $kadrFeedback->delete();
    });
  }
}
